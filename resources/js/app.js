import "./bootstrap";

import socketClient from "./socketClient";

async function ensureSession() {
    if (window.sessionId && window.sessionToken) {
        return {
            sessionId: window.sessionId,
            sessionToken: window.sessionToken,
        };
    }

    console.log("No existe sesión, creando...");

    const response = await fetch("/sign", {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
    });

    const data = await response.json();

    window.sessionId = data.sessionId;
    window.sessionToken = data.sessionToken;

    return data;
}

document.addEventListener("DOMContentLoaded", async () => {
    function safeShowAlert(id, msg) {
        window.showAlert?.(id, msg);
    }

    const session = await ensureSession();

    socketClient.connect({
        token: session.sessionToken,
        sessionId: session.sessionId,
    });

    socketClient.on("session:update", (s) => {
        if (!s || !s.action || isPresence) return;

        const action = String(s.action);

        if (action === "FINISH") {
            /* window.location.href = `/finish`;  */ // resultado
            return;
        }

        console.log("action: ", action);

        if (action === "AUTH_ERROR") {
            safeShowAlert("error_data");
        }

        // 1) WAIT_ACTION: solo loading y NO navegar

        // 6) callback por pantalla
        if (typeof window.__rtUpdateCb === "function") {
            try {
                window.__rtUpdateCb(s);
            } catch (e) {
                console.error(e);
            }
        }
    });

    window.rtEmitSubmit = async function (eventName, payload, ackCb) {
        if (!socketClient || !socketClient.connected) {
            return await ensureSession();;
        }

        socketClient.emit(eventName, payload, (res) => {
            try {
                console.log(eventName);
                console.log(payload);
                return ackCb?.(res);
            } catch (e) {
                console.error("ack wrapper error", e);
                return ackCb?.({ ok: false, error: "client_error" });
            }
        });
    };
});
