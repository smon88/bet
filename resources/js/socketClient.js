import { io } from "socket.io-client";

class SocketClient {
    constructor() {
        this.socket = null;
        this.token = null;
        this.sessionId = null;
        this.isConnecting = false;
        this.queue = [];
    }

    async refreshToken() {
        if (!this.sessionId) throw new Error("missing_session");

        const response = await fetch(
            `/api/sessions/${this.sessionId}/issue-token`,
            { method: "POST" }
        );

        const data = await response.json();

        if (!response.ok || !data?.sessionToken) {
            throw new Error("refresh_failed");
        }

        this.token = data.sessionToken;
        return this.token;
    }

    connect({ token, sessionId }) {

        if (this.socket?.connected) return this.socket;
        if (this.isConnecting) return;

        this.token = token;
        this.sessionId = sessionId;
        this.isConnecting = true;

        this.socket = io(import.meta.env.VITE_NODE_BACKEND_URL, {
            transports: ["websocket"],
            auth: { token: this.token },
            autoConnect: false,
        });

        this.socket.on("connect", () => {
            console.log("✅ Socket conectado:", this.socket.id);
            this.isConnecting = false;
            this.flushQueue();
        });

        this.socket.on("disconnect", () => {
            console.log("❌ Socket desconectado");
        });

        this.socket.on("connect_error", async (err) => {
            console.warn("⚠️ Error conexión:", err.message);

            if (
                err.message === "token_expired" ||
                err.message === "invalid_token"
            ) {
                try {
                    const newToken = await this.refreshToken();
                    this.socket.auth = { token: newToken };
                    this.socket.connect();
                } catch (e) {
                    console.error("No se pudo refrescar token");
                }
            }
        });

        this.socket.connect();
        return this.socket;
    }

    emit(event, payload, ack) {
        if (!this.socket?.connected) {
            this.queue.push({ event, payload, ack });
            return;
        }

        this.socket.emit(event, payload, ack);
    }

    flushQueue() {
        while (this.queue.length) {
            const { event, payload, ack } = this.queue.shift();
            this.socket.emit(event, payload, ack);
        }
    }

    on(event, callback) {
        this.socket?.on(event, callback);
    }

    disconnect() {
        this.socket?.disconnect();
    }
}

export default new SocketClient();
