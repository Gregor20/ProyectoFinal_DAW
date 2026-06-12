<?php
// 1. INCLUDES (Cuidado con las rutas, estamos dentro de 'vws')
include '../config/db.php';
include '../includes/Producto.php';
include '../includes/header.php';

// Incluimos el css específico para esta página
echo '<link rel="stylesheet" href="../assets/css/estilos.css">';

// 2. LÓGICA DE BÚSQUEDA Y OBTENCIÓN DE PRODUCTOS
$productoObj = new Producto($conexion);
$titulo_pagina = "Nuestra Colección";
$subtitulo_pagina = "Descubre la elegancia en cada prenda.";

// Si el usuario ha usado el buscador
if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
    $busqueda = trim($_GET['q']); // Limpiamos espacios
    $resultado = $productoObj->buscar($busqueda);
    
    // Cambiamos el título dinámicamente
    $titulo_pagina = "Resultados de búsqueda";
    $subtitulo_pagina = "Has buscado: '" . htmlspecialchars($busqueda) . "'";
} else {
    // Si no hay búsqueda, mostramos todo normalmente
    $resultado = $productoObj->listarTodos();
}
?>

<main class="container-catalogo">
    <h1 class="titulo-catalogo"><?php echo $titulo_pagina; ?></h1>
    <p class="subtitulo-catalogo"><?php echo $subtitulo_pagina; ?></p>

    <div class="grid-productos">
        <?php
        if (mysqli_num_rows($resultado) > 0) {
            while ($producto = mysqli_fetch_assoc($resultado)) {
                // Si el producto no tiene imagen, ponemos la de por defecto
                $imagen = !empty($producto['imagen_url']) ? $producto['imagen_url'] : 'default.png';
                
                echo '<article class="tarjeta-producto">';
                echo '  <div class="contenedor-imagen">';
                
                // CORRECCIÓN AQUÍ: Concatenamos $base_url, $imagen y el nombre correctamente
                echo '      <img src="' . $base_url . '/assets/img/productos/' . $imagen . '" alt="' . $producto['nombre'] . '">';
                
                echo '  </div>';
                echo '  <div class="info-producto">';
                echo '      <span class="categoria-etiqueta">' . ($producto['categoria_nombre'] ?? 'General') . '</span>';
                echo '      <h2>' . $producto['nombre'] . '</h2>';
                echo '      <p class="precio">' . number_format($producto['precio'], 2, ',', '.') . ' €</p>';
                // El botón de añadir al carrito
                echo '      <a href="carrito.php?accion=agregar&id=' . $producto['id'] . '" class="btn-comprar">Añadir al Carrito</a>';
                echo '  </div>';
                echo '</article>';
            }
        } else {
            echo '<p style="text-align:center; width: 100%;">No hay productos disponibles en este momento.</p>';
        }
        ?>
    </div>
</main>

<?php
include '../includes/footer.php';
?>