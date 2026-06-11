/* ============================================================
   CARRITO — LÓGICA COMPLETA
   ============================================================ */

let carrito = [];

/* ============================================================
   Cargar carrito desde localStorage al iniciar
   ============================================================ */
document.addEventListener("DOMContentLoaded", () => {
    const data = localStorage.getItem("carrito");

    if (data) {
        carrito = JSON.parse(data);
    }

    actualizarCarritoUI();
});

/* ============================================================
   Guardar carrito en localStorage
   ============================================================ */
function guardarCarrito() {
    localStorage.setItem("carrito", JSON.stringify(carrito));
}

/* ============================================================
   Añadir producto al carrito
   ============================================================ */
function agregarAlCarrito(producto) {
    const existe = carrito.find(item => item.id === producto.id);

    if (existe) {
        existe.cantidad++;
    } else {
        carrito.push({ ...producto, cantidad: 1 });
    }

    guardarCarrito();
    actualizarCarritoUI();
}

/* ============================================================
   Eliminar producto del carrito
   ============================================================ */
function eliminarDelCarrito(id) {
    carrito = carrito.filter(item => item.id !== id);
    guardarCarrito();
    actualizarCarritoUI();
}

/* ============================================================
   Actualizar cantidad
   ============================================================ */
function cambiarCantidad(id, nuevaCantidad) {
    const item = carrito.find(p => p.id === id);

    if (item) {
        item.cantidad = nuevaCantidad;

        if (item.cantidad <= 0) {
            eliminarDelCarrito(id);
            return;
        }
    }

    guardarCarrito();
    actualizarCarritoUI();
}

/* ============================================================
   Calcular total
   ============================================================ */
function calcularTotal() {
    return carrito.reduce((acc, item) => acc + item.precio * item.cantidad, 0);
}

/* ============================================================
   Actualizar interfaz del carrito (carrito.php)
   ============================================================ */
function actualizarCarritoUI() {
    const tabla = document.querySelector("#carrito-body");
    const total = document.querySelector("#carrito-total");

    if (!tabla || !total) return;

    tabla.innerHTML = "";

    carrito.forEach(item => {
        const fila = document.createElement("tr");

        fila.innerHTML = `
            <td><img src="../assets/img/${item.imagen}" class="carrito-img"></td>
            <td>${item.nombre}</td>
            <td>${item.precio} €</td>
            <td>
                <input type="number" min="1" value="${item.cantidad}" 
                onchange="cambiarCantidad(${item.id}, this.value)">
            </td>
            <td>${item.precio * item.cantidad} €</td>
            <td>
                <button class="btn-remove" onclick="eliminarDelCarrito(${item.id})">X</button>
            </td>
        `;

        tabla.appendChild(fila);
    });

    total.textContent = calcularTotal().toFixed(2) + " €";
}
