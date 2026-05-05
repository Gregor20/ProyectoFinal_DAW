<?php
//incluimos la conexión a la base de datos
include '../config/db.php';
// Incluimos el header
include '../includes/header.php';
?>

<div class="container">
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
            <!-- Aquí se cargan los productos mediante PHP -->
            <!-- Usamos una consulta SELECT mediante sql -->
             <?php
            // Llamamos a la base de datos directamente con PHP
            $sql = "SELECT p.*, c.nombre as categoria_nombre 
                    FROM productos p 
                    LEFT JOIN categorias c ON p.id_categoria = c.id";
            $resultado = mysqli_query($conexion, $sql);

            // mysqli_num_rows hace que se cuente el número de filas que devuelve la consulta,
            // si es mayor a 0, se muestra la tabla
            if (mysqli_num_rows($resultado) > 0) {

                // mysqli_fetch_assoc devuelve un array asociativo con los datos de cada fila.
                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['precio'] . "€</td>";
                    echo "<td>" . $row['categoria_nombre'] . "</td>";
                    echo "<td>
                            <a href='editar.php?id=".$row['id']."'>Editar</a> | 
                            <a href='eliminar.php?id=".$row['id']."' style='color:red;'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay productos registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


<?php
// Incluimos el footer
include '../includes/footer.php';
?>