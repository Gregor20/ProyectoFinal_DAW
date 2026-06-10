<?php
// 1. INCLUDES
include '../config/db.php';
include '../includes/Producto.php';
include '../includes/header.php';

// 2. VALIDAR Y CAPTURAR EL ID DE LA URL (Fase GET)
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Seguridad
    
    $productoObj = new Producto($conexion);
    $datos_producto = $productoObj->obtenerPorId($id);

    // Si el producto no existe en la BD
    if (!$datos_producto) {
        header("Location: index.php?status=not_found");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// 3. PROCESAR EL FORMULARIO CUANDO SE ENVÍA (Fase POST)
if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $id_categoria = $_POST['id_categoria'];
    
    // Por defecto mandamos NULL (la clase mantendrá la foto vieja si es NULL)
    $imagen_para_bd = NULL; 

    // ¿El administrador ha subido una NUEVA foto?
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombre_imagen = time() . "_" . $_FILES['imagen']['name'];
        $tipo_imagen = $_FILES['imagen']['type'];
        $tmp_name = $_FILES['imagen']['tmp_name'];
        $carpeta_destino = "../assets/img/productos/";
        $formato_permitido = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

        if (in_array($tipo_imagen, $formato_permitido)) {
            if (move_uploaded_file($tmp_name, $carpeta_destino . $nombre_imagen)) {
                $imagen_para_bd = $nombre_imagen; // Tenemos nueva foto
            }
        }
    }

    // Llamamos al método actualizar de la clase
    if ($productoObj->actualizar($id, $nombre, $precio, $descripcion, $id_categoria, $imagen_para_bd)) {
        header("Location: index.php?status=updated");
        exit();
    } else {
        echo "<p class='error'>Error al actualizar el producto.</p>";
    }
}
?>

<div class="container-crear">
    <h1>Editar Producto: <?php echo $datos_producto['nombre']; ?></h1>

    <form action="" method="POST" enctype="multipart/form-data">
        
        <label>Nombre del producto:</label>
        <input type="text" name="nombre" value="<?php echo $datos_producto['nombre']; ?>" required />

        <label>Precio (€):</label>
        <input type="number" name="precio" step="0.01" value="<?php echo $datos_producto['precio']; ?>" required />

        <label>Descripción:</label>
        <textarea name="descripcion" required><?php echo $datos_producto['descripcion']; ?></textarea>

        <label>Categoría:</label>
        <select name="id_categoria" required>
            <?php
                $sql = "SELECT * FROM categorias";
                $resultado_cat = mysqli_query($conexion, $sql);
                while($categoria = mysqli_fetch_assoc($resultado_cat)) {
                    // TRUCO TÉCNICO: Si la categoría coincide con la del producto, le metemos el atributo 'selected'
                    $selected = ($categoria['id'] == $datos_producto['id_categoria']) ? 'selected' : '';
                    echo "<option value='" . $categoria['id'] . "' $selected>" . $categoria['nombre'] . "</option>";
                }
            ?>
        </select>

        <label>Imagen del producto:</label>
        <div style="margin-bottom: 10px;">
            <p style="font-size: 14px; color: #666; margin-bottom: 5px;">Imagen actual:</p>
            <img src="../assets/img/productos/<?php echo $datos_producto['imagen_url']; ?>" alt="Actual" width="80" style="border-radius: 4px; border: 1px solid #ddd;">
        </div>
        <input name="imagen" type="file" />
        <span style="font-size: 12px; color: #777;">(Opcional. Sube una foto solo si deseas cambiar la actual)</span>

        <button type="submit" name="actualizar" class="btn-crear">Guardar Cambios</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>