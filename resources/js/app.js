import './bootstrap';


// Función para conectarse al socket server
export function connectSocket(userId) {
    const socket = io("http://tu-server-express:3000", {
        auth: {
            userId: userId // puedes enviar token o ID seguro
        }
    });

    socket.on("connect", () => {
        console.log("Conectado al Socket Server:", socket.id);
    });

    socket.on("disconnect", () => {
        console.log("Desconectado del Socket Server");
    });

    // Eventos personalizados
    socket.on("message", (data) => {
        console.log("Mensaje recibido:", data);
    });

    return socket;
}