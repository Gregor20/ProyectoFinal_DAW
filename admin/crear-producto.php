<?php
session_start();
// Si no hay sesión, o si el rol no es 1 (Administrador), ¡lo echamos!
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 1) {
    header("Location: ../vws/login.php");
    exit();
}
//incluimos la conexión a la base de datos
include '../config/db.php';
// Incluimos el header
include '../includes/header.php';
// Incluimos la clase Producto
include '../includes/Producto.php';
// Inlcuimos el css específico para esta página
echo '<link rel="stylesheet" href="../assets/css/estilos.css">';
?>
<div class="container-crear">
    <h1>Crear nuevo producto</h1>

    <form action="crear-producto.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Ingresa el nombre del producto" required />

        <!-- puedes avanzar de céntimo en céntimo con step="0.01" -->
        <input type="number" name="precio" step="0.01" placeholder="Ingresa el precio del producto" required />

        <textarea name="descripcion" placeholder="Ingresa la descripción del producto" required></textarea>

        <select name="id_categoria" required>
            <option value="">Selecciona una categoría</option>
            <?php
                // Obtenemos las categorías de la base de datos para mostrarlas en el select
                $sql = "SELECT * FROM categorias";
                $resultado = mysqli_query($conexion, $sql);
                while($categoria = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='" . $categoria['id'] . "'>" . $categoria['nombre'] . "</option>";
                }
            ?>
        </select>
        <input name="imagen" type="file" />Ingresa la imagen del producto (opcional).
        <button type="submit" name="crear" class="btn-crear">Crear producto</button>
    </form>
    <?php
        // Si se ha enviado el formulario, creamos el producto
        if(isset($_POST['crear'])){
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $descripcion = $_POST['descripcion'];
            $id_categoria = $_POST['id_categoria'];

            $imagen_para_bd = 'default.png'; 

            // ¿Se ha seleccionado una imagen? (error 0 significa que todo ok, error 4 significa vacío)
            if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {

                // Recoger datos del archivo
                $nombre_imagen = time() . "_" . $_FILES['imagen']['name']; // Añadimos un timestamp para evitar el mismo nombre
                $tipo_imagen = $_FILES['imagen']['type'];
                $tmp_name = $_FILES['imagen']['tmp_name'];
                $carpeta_destino = "../assets/img/productos/"; // Carpeta donde se guardarán las imágenes
                $formato_permitido = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

                if(!in_array($tipo_imagen, $formato_permitido)){
                    echo "<p class='error'>Formato de imagen no permitido.</p>";
                }else {
                    // 3. Mover el archivo de la carpeta temporal a la nuestra
                    if (move_uploaded_file($tmp_name, $carpeta_destino . $nombre_imagen)) {

                    // Si se movió con éxito, el nombre para la BD será el nombre del archivo
                    $imagen_para_bd = $nombre_imagen;
                    } else {
                        echo "<p class='error'>Error al subir la imagen.</p>";
                    }
                }
            }

            // Creamos una instancia de la clase Producto
            $producto = new Producto($conexion);

            // Ahora llamamos a la clase con el nombre de la imagen
            if($producto->crear($nombre, $precio, $descripcion, $id_categoria, $imagen_para_bd)) {
                echo "<p class='exito'>Producto creado correctamente</p>";
            } else {
                echo "<p class='error'>Error al crear el producto</p>";
            }
        }
    ?>

</div>