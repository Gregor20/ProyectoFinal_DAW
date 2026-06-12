/* ============================================================
   VALIDACIÓN DE EMAIL AVANZADA
   ============================================================ */

function validarEmailAvanzado(email) {

    // 1. No permitir espacios
    if (email.includes(" ")) return false;

    // 2. Formato correcto (regex profesional)
    const regexFormato = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}$/;
    if (!regexFormato.test(email)) return false;

    // 3. No permitir caracteres raros
    const regexRaros = /[(),:;<>[\]{}]/;
    if (regexRaros.test(email)) return false;

    // 4. Lista de dominios temporales prohibidos
    const dominiosTemporales = [
        "tempmail.com", "10minutemail.com", "guerrillamail.com",
        "mailinator.com", "yopmail.com", "trashmail.com"
    ];

    const dominio = email.split("@")[1].toLowerCase();
    if (dominiosTemporales.includes(dominio)) return false;

    // 5. No permitir dominios falsos comunes
    const dominiosFalsos = ["gmail.con", "hotmai.com", "outlok.com"];
    if (dominiosFalsos.includes(dominio)) return false;

    return true;
}

/* ============================================================
   VALIDACIÓN DE CONTRASEÑA FUERTE
   ============================================================ */

function validarContrasenaFuerte(pass) {

    // 1. Longitud mínima
    if (pass.length < 8) return false;

    // 2. No permitir espacios
    if (pass.includes(" ")) return false;

    // 3. Debe tener mayúscula
    if (!/[A-Z]/.test(pass)) return false;

    // 4. Debe tener minúscula
    if (!/[a-z]/.test(pass)) return false;

    // 5. Debe tener número
    if (!/[0-9]/.test(pass)) return false;

    // 6. Debe tener símbolo
    if (!/[!@#$%^&*()_\-+=



}
;:,.<>/?|]/.test(pass)) return false;

    // 7. No permitir más de 3 caracteres repetidos seguidos
    if (/(.)\1\1\1/.test(pass)) return false;

    return true;
{}

/* ============================================================
   VALIDACIÓN DE NOMBRE REAL
   ============================================================ */

function validarNombreReal(nombre) {

    // 1. Quitar espacios al inicio y final
    nombre = nombre.trim();

    // 2. No permitir vacío
    if (nombre.length === 0) return false;

    // 3. No permitir números
    if (/[0-9]/.test(nombre)) return false;

    // 4. No permitir símbolos raros
    if (/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(nombre)) return false;

    // 5. No permitir más de 3 espacios seguidos
    if (/\s{3,}/.test(nombre)) return false;

    // 6. No permitir palabras de 1 letra (ej: "a", "b", "x")
    const partes = nombre.split(" ");
    for (let p of partes) {
        if (p.length === 1) return false;
    }

    // 7. No permitir nombres absurdos (ej: "aaaaaa", "zzzzzz")
    if (/^(.)\1+$/.test(nombre)) return false;

    return true;
}
/* ============================================================
   VALIDACIÓN DE TELÉFONO (ESPAÑA)
   ============================================================ */

function validarTelefono(telefono) {

    // 1. Quitar espacios
    telefono = telefono.trim();

    // 2. No permitir vacío
    if (telefono.length === 0) return false;

    // 3. No permitir "+"
    if (telefono.includes("+")) return false;

    // 4. Solo números
    if (!/^[0-9]+$/.test(telefono)) return false;

    // 5. Longitud exacta (España = 9 dígitos)
    if (telefono.length !== 9) return false;

    // 6. No permitir números absurdos (ej: 000000000)
    if (/^(.)\1+$/.test(telefono)) return false;

    return true;
}

/* ============================================================
   VALIDACIÓN DE DIRECCIÓN
   ============================================================ */

function validarDireccion(direccion) {

    // 1. Quitar espacios al inicio y final
    direccion = direccion.trim();

    // 2. No permitir vacío
    if (direccion.length === 0) return false;

    // 3. Mínimo 10 caracteres
    if (direccion.length < 10) return false;

    // 4. No permitir solo números
    if (/^[0-9]+$/.test(direccion)) return false;

    // 5. No permitir símbolos raros
    if (/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,\-ºª]/.test(direccion)) return false;

    // 6. No permitir palabras repetidas (ej: "calle calle calle")
    const partes = direccion.toLowerCase().split(" ");
    const repetidas = partes.filter((p, i) => partes.indexOf(p) !== i);
    if (repetidas.length > 0) return false;

    // 7. No permitir direcciones absurdas (ej: "aaaaaa", "zzzzzz")
    if (/^(.)\1+$/.test(direccion.replace(/\s/g, ""))) return false;

    return true;
}

/* ============================================================
   VALIDACIÓN DE MENSAJE LARGO
   ============================================================ */

function validarMensajeLargo(mensaje) {

    // 1. Quitar espacios al inicio y final
    mensaje = mensaje.trim();

    // 2. No permitir vacío
    if (mensaje.length === 0) return false;

    // 3. Mínimo 10 caracteres
    if (mensaje.length < 10) return false;

    // 4. Máximo 500 caracteres
    if (mensaje.length > 500) return false;

    // 5. No permitir insultos (lista básica)
    const insultos = ["puta", "mierda", "gilipollas", "idiota", "subnormal"];
    for (let palabra of insultos) {
        if (mensaje.toLowerCase().includes(palabra)) return false;
    }

    // 6. No permitir spam (links repetidos)
    const links = mensaje.match(/https?:\/\/\S+/g);
    if (links && links.length > 3) return false;

    // 7. No permitir mensajes absurdos (ej: "aaaaaa", "zzzzzz")
    if (/^(.)\1+$/.test(mensaje.replace(/\s/g, ""))) return false;

    return true;
}

/* ============================================================
   VALIDACIÓN DE CAMPOS VACÍOS
   ============================================================ */

function validarCampoVacio(selector) {
    const input = document.querySelector(selector);
    if (!input) return false;

    const valor = input.value.trim();

    if (valor === "") {
        marcarError(selector);
        return false;
    }

    marcarOk(selector);
    return true;
}

/* ============================================================
   VALIDACIÓN DE CHECKBOX OBLIGATORIO
   ============================================================ */

function validarCheckbox(selector) {
    const check = document.querySelector(selector);
    if (!check) return false;

    if (!check.checked) {
        mostrarError("Debes aceptar los términos y condiciones");
        check.classList.add("input-error");
        return false;
    }

    check.classList.remove("input-error");
    check.classList.add("input-ok");
    return true;
}

/* ============================================================
   VALIDACIÓN DE SELECTS
   ============================================================ */

function validarSelect(selector) {
    const select = document.querySelector(selector);
    if (!select) return false;

    const valor = select.value.trim();

    // 1. No permitir vacío
    if (valor === "") {
        marcarError(selector);
        return false;
    }

    // 2. No permitir opción por defecto
    if (valor === "default" || valor === "selecciona" || valor === "0") {
        marcarError(selector);
        return false;
    }

    // 3. Si todo está bien
    marcarOk(selector);
    return true;
}

/* ============================================================
   VALIDACIÓN DE IMÁGENES (ADMIN)
   ============================================================ */

async function validarImagenAdmin(selector) {
    const input = document.querySelector(selector);
    if (!input || !input.files || input.files.length === 0) {
        mostrarError("Debes seleccionar una imagen");
        marcarError(selector);
        return false;
    }

    const file = input.files[0];

    // 1. Tamaño máximo (2MB)
    const maxSize = 2 * 1024 * 1024;
    if (file.size > maxSize) {
        mostrarError("La imagen no puede superar los 2MB");
        marcarError(selector);
        return false;
    }

    // 2. Formatos permitidos
    const formatosPermitidos = ["image/jpeg", "image/png", "image/webp"];
    if (!formatosPermitidos.includes(file.type)) {
        mostrarError("Formato no permitido (solo JPG, PNG o WEBP)");
        marcarError(selector);
        return false;
    }

    // 3. Validar resolución mínima (300x300)
    const resolucionValida = await validarResolucion(file, 300, 300);
    if (!resolucionValida) {
        mostrarError("La imagen debe tener al menos 300x300 píxeles");
        marcarError(selector);
        return false;
    }

    marcarOk(selector);
    return true;
}
/* ============================================================
   VALIDACIÓN DE CANTIDADES DEL CARRITO
   ============================================================ */

function validarCantidadCarrito(cantidad) {

    // Convertir a número
    cantidad = Number(cantidad);

    // No permitir NaN
    if (isNaN(cantidad)) return false;

    // No permitir negativo
    if (cantidad < 1) return false;

    // No permitir cantidades absurdas
    if (cantidad > 9999) return false;

    return true;
}
/* ============================================================
   VALIDACIÓN DE TARJETA (BÁSICA)
   ============================================================ */

function validarTarjeta(numero) {
    numero = numero.replace(/\s/g, "");

    // Solo números
    if (!/^[0-9]+$/.test(numero)) return false;

    // Longitud típica: 16 dígitos
    if (numero.length !== 16) return false;

    // Algoritmo Luhn (validación real de tarjetas)
    let suma = 0;
    let alternar = false;

    for (let i = numero.length - 1; i >= 0; i--) {
        let n = parseInt(numero[i]);

        if (alternar) {
            n *= 2;
            if (n > 9) n -= 9;
        }

        suma += n;
        alternar = !alternar;
    }

    return (suma % 10 === 0);
}
/* ============================================================
   VALIDACIÓN DE PRECIO
   ============================================================ */

function validarPrecio(precio) {
    precio = Number(precio);

    if (isNaN(precio)) return false;
    if (precio <= 0) return false;
    if (precio > 9999) return false;

    return true;
}
