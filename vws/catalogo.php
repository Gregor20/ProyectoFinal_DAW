<?php
// 1. INCLUDES (Cuidado con las rutas, estamos dentro de 'vws')
include '../config/db.php';
include '../includes/Producto.php';
include '../includes/header.php';
// Inlcuimos el css específico para esta página
echo '<link rel="stylesheet" href="../assets/css/estilos.css">';

// 2. OBTENER LOS PRODUCTOS
$productoObj = new Producto($conexion);
$resultado = $productoObj->listarTodos();
?>

<main class="container-catalogo">
    <h1 class="titulo-catalogo">Nuestra Colección</h1>
    <p class="subtitulo-catalogo">Descubre la elegancia en cada prenda.</p>

    <div class="grid-productos">
        <?php
        if (mysqli_num_rows($resultado) > 0) {
            while ($producto = mysqli_fetch_assoc($resultado)) {
                // Si el producto no tiene imagen, ponemos la de por defecto
                $imagen = !empty($producto['imagen_url']) ? $producto['imagen_url'] : 'default.png';
                
                echo '<article class="tarjeta-producto">';
                echo '  <div class="contenedor-imagen">';
                echo '      <img src="../assets/img/productos/' . $imagen . '" alt="' . $producto['nombre'] . '">';
                echo '  </div>';
                echo '  <div class="info-producto">';
                echo '      <span class="categoria-etiqueta">' . ($producto['categoria_nombre'] ?? 'General') . '</span>';
                echo '      <h2>' . $producto['nombre'] . '</h2>';
                echo '      <p class="precio">' . number_format($producto['precio'], 2, ',', '.') . ' €</p>';
                // El botón de añadir al carrito (lo conectaremos en la siguiente fase)
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