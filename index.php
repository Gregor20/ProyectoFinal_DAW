<?php
session_start();

// 1. INCLUDES (Como estamos en la raíz, no hace falta el "../")
include 'config/db.php';
include 'includes/Producto.php';
include 'includes/header.php';
?>

<main>
    <section style="background-image: linear-gradient(rgba(10, 10, 10, 0.6), rgba(10, 10, 10, 0.9)), url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1600&q=80'); background-size: cover; background-position: center; height: 75vh; display: flex; align-items: center; justify-content: center; text-align: center; border-bottom: 1px solid var(--borde-dorado);">
        <div style="padding: 0 20px;">
            <h1 style="font-size: 55px; margin-bottom: 15px; letter-spacing: 2px;">Elegancia Atemporal</h1>
            <p style="font-size: 22px; color: var(--texto-claro); margin-bottom: 40px; font-style: italic; font-weight: 300;">Descubre la nueva colección Primavera 2026</p>
            <a href="vws/catalogo.php" class="btn-primary" style="text-decoration: none; font-size: 16px; padding: 15px 45px;">Explorar Colección</a>
        </div>
    </section>

    <section style="max-width: 1200px; margin: 80px auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 50px;">
            <h2 style="font-size: 32px; letter-spacing: 1px;">Piezas Destacadas</h2>
            <div style="width: 60px; height: 2px; background-color: var(--dorado); margin: 15px auto;"></div>
        </div>

        <div class="grid-productos">
            <?php
            $productoObj = new Producto($conexion);
            $resultado = $productoObj->listarTodos();
            
            // Usamos un contador para mostrar SOLO los primeros 3 productos en la portada
            $contador = 0;

            if (mysqli_num_rows($resultado) > 0) {
                while ($producto = mysqli_fetch_assoc($resultado)) {
                    if ($contador >= 3) {
                        break; // Si ya hemos pintado 3, detenemos el bucle
                    }
                    
                    // RECUPERAMOS ESTA LÍNEA (Es vital para saber qué foto cargar)
                    $imagen = !empty($producto['imagen_url']) ? $producto['imagen_url'] : 'default.png';
                    ?>
                    
                    <article class="tarjeta-producto">
                        <div class="contenedor-imagen">
                            <img src="<?php echo $base_url; ?>/assets/img/productos/<?php echo $imagen; ?>" alt="<?php echo $producto['nombre']; ?>">
                        </div>
                        <div class="info-producto">
                            <span class="categoria-etiqueta"><?php echo $producto['categoria_nombre'] ?? 'General'; ?></span>
                            <h2 style="font-size: 18px; margin: 10px 0;"><?php echo $producto['nombre']; ?></h2>
                            <p class="precio" style="font-size: 20px; color: var(--dorado); margin-bottom: 20px;"><?php echo number_format($producto['precio'], 2, ',', '.'); ?> €</p>
                            
                            <a href="vws/carrito.php?accion=agregar&id=<?php echo $producto['id']; ?>" class="btn-comprar">Añadir al Carrito</a>
                        </div>
                    </article>

                    <?php
                    $contador++;
                }
            } else {
                echo '<p style="text-align:center; width: 100%;">Próximamente nuevas colecciones.</p>';
            }
            ?>
        </div>
        
        <div style="text-align: center; margin-top: 50px;">
            <a href="vws/catalogo.php" style="color: var(--texto-claro); text-decoration: none; border-bottom: 1px solid var(--dorado); padding-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: color 0.3s;">Ver todo el catálogo &#8594;</a>
        </div>
    </section>
</main>

<?php
include 'includes/footer.php';
?>