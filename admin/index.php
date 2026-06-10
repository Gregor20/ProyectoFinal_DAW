<?php
// Incluimos la conexión a la base de datos
include '../config/db.php';
// Incluimos la clase Producto (¡No te olvides de esta!)
include '../includes/Producto.php';
// Incluimos el header
include '../includes/header.php';

// Instanciamos el objeto Producto
$productoObj = new Producto($conexion);
// Llamamos al método de la clase
$resultado = $productoObj->listarTodos();
?>

<div class="container">
    <h1>Panel de Administración - Productos</h1>
    <?php
    // Capturamos el estado de la URL si existe
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'deleted') {
                echo "<p class='exito' style='background-color: #f8d7da; color: #721c24; border-color: #f5c6cb;'>¡Producto eliminado correctamente de la tienda!</p>";
            } 
        // ¡AÑADIDO AQUÍ EL NUEVO AVISO!
        elseif ($_GET['status'] == 'updated') {
            echo "<p class='exito' style='background-color: #d1ecf1; color: #0c5460; border-color: #bee5eb;'>¡Producto actualizado con éxito!</p>";
        } 
        elseif ($_GET['status'] == 'error') {
            echo "<p class='error'>No se pudo realizar la acción. Inténtalo de nuevo.</p>";
        }
    }
    ?>
    
    <table class="listado-productos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="productos-lista">
            <?php
            // Comprobamos si hay filas en el resultado que nos dio la clase
            if (mysqli_num_rows($resultado) > 0) {

                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['precio'] . "€</td>";
                    echo "<td>" . ($row['categoria_nombre'] ?? 'Sin categoría') . "</td>";
                    
                    // CORRECCIÓN: Añadimos la celda de la imagen que faltaba
                    echo "<td><img src='../assets/img/productos/" . $row['imagen_url'] . "' alt='Foto' width='50' style='object-fit: cover; border-radius: 4px;'></td>";
                    
                    // CORRECCIÓN: Rutas ajustadas a tus archivos reales de admin
                    echo "<td>
                            <a href='editar-producto.php?id=" . $row['id'] . "' class='btn-editar'>Editar</a> | 
                            <a href='eliminar-producto.php?id=" . $row['id'] . "' class='btn-eliminar' style='color:red;'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                // CORRECCIÓN: colspan='6' porque ahora tenemos 6 columnas reales
                echo "<tr><td colspan='6'>No hay productos registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Incluimos el footer
include '../includes/footer.php';
?>