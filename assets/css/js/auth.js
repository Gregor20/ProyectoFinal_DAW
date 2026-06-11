/* ============================================================
   AUTH.JS — CONTROL DE SESIÓN
   ============================================================ */

async function comprobarSesion() {
    try {
        const respuesta = await fetch("../auth.php");
        const datos = await respuesta.json();

        if (!datos.logueado) {
            window.location.href = "../login.php";
        }
    } catch (error) {
        console.error("Error comprobando sesión:", error);
        window.location.href = "../login.php";
    }
}
async function comprobarAdmin() {
    try {
        const respuesta = await fetch("../auth.php");
        const datos = await respuesta.json();

        if (!datos.logueado || datos.rol !== "admin") {
            window.location.href = "../index.php";
        }
    } catch (error) {
        console.error("Error comprobando admin:", error);
        window.location.href = "../index.php";
    }
}
function cerrarSesion() {
    fetch("../logout.php")
        .then(() => window.location.href = "../index.php");
}
