/* ============================================================
   CATALOGO — BOTONES, ANIMACIONES Y EFECTOS 
   ============================================================ */

document.addEventListener("DOMContentLoaded", () => {
    const botones = document.querySelectorAll(".btn-add");

    botones.forEach(boton => {
        boton.addEventListener("click", (e) => {

            animarBoton(boton);

            const producto = {
                id: parseInt(boton.dataset.id),
                nombre: boton.dataset.nombre,
                precio: parseFloat(boton.dataset.precio),
                imagen: boton.dataset.imagen
            };

            const existe = carrito.find(item => item.id === producto.id);

            if (existe) {
                existe.cantidad++;
                guardarCarrito();
                actualizarCarritoUI();
                mostrarMensaje(`Cantidad actualizada (${existe.cantidad})`);
                efectoVolador(e, boton.dataset.imagen);
                return;
            }

            agregarAlCarrito(producto);
            mostrarMensaje("Producto añadido al carrito");
            efectoVolador(e, boton.dataset.imagen);
        });
    });
});

/* ============================================================
   ANIMACIÓN DEL BOTÓN
   ============================================================ */
function animarBoton(boton) {
    boton.classList.add("btn-animado");
    setTimeout(() => boton.classList.remove("btn-animado"), 300);
}

/* ============================================================
   EFECTO “PRODUCTO VOLANDO AL CARRITO”
   ============================================================ */
function efectoVolador(event, imagen) {
    const img = document.createElement("img");
    img.src = `../assets/img/${imagen}`;
    img.classList.add("volador");

    document.body.appendChild(img);

    const x = event.clientX;
    const y = event.clientY;

    img.style.left = x + "px";
    img.style.top = y + "px";

    const carritoIcon = document.querySelector(".carrito-icon");

    if (!carritoIcon) return;

    const rect = carritoIcon.getBoundingClientRect();

    setTimeout(() => {
        img.style.left = rect.left + "px";
        img.style.top = rect.top + "px";
        img.style.opacity = "0";
        img.style.transform = "scale(0.2)";
    }, 50);

    setTimeout(() => img.remove(), 600);
}

/* ============================================================
   MENSAJE FLOTANTE
   ============================================================ */
function mostrarMensaje(texto) {
    const msg = document.createElement("div");
    msg.classList.add("mensaje-carrito");
    msg.textContent = texto;

    document.body.appendChild(msg);

    setTimeout(() => msg.classList.add("visible"), 50);

    setTimeout(() => {
        msg.classList.remove("visible");
        setTimeout(() => msg.remove(), 300);
    }, 1500);
}
