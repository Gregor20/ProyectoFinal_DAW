// Esperamos a que todo el HTML de la página esté cargado
document.addEventListener("DOMContentLoaded", function() {
    
    // 1. AUTO-OCULTAR MENSAJES DE ÉXITO Y ERROR
    // Buscamos todos los elementos que tengan la clase 'exito' o 'error'
    const alertas = document.querySelectorAll('.exito, .error');
    
    // Si encontramos alguna alerta en la página...
    if (alertas.length > 0) {
        // Esperamos 4 segundos (4000 milisegundos)
        setTimeout(() => {
            alertas.forEach(alerta => {
                // Le damos una transición CSS suave desde JS
                alerta.style.transition = "opacity 0.5s ease";
                alerta.style.opacity = "0"; // Lo hacemos transparente
                
                // Esperamos medio segundo más a que termine la animación y lo borramos del HTML
                setTimeout(() => alerta.remove(), 500);
            });
        }, 4000);
    }
});