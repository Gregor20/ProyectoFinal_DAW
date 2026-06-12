<?php
session_start();
// Si no hay sesión, o si el rol no es 1 (Administrador), ¡lo echamos!
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 1) {
    header("Location: ../vws/login.php");
    exit();
}
// 1. Incluimos las dependencias necesarias
include '../config/db.php';
include '../includes/Producto.php';
// Inlcuimos el css específico para esta página
echo '<link rel="stylesheet" href="../assets/css/estilos.css">';

// 2. Comprobamos si el ID viaja en la URL y no está vacío
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    // Filtramos el ID para asegurarnos de que sea un número entero (Seguridad)
    $id = intval($_GET['id']); 

    // 3. Instanciamos la clase Producto
    $productoObj = new Producto($conexion);

    // 4. Intentamos borrar el producto
    if ($productoObj->borrar($id)) {
        // Si se borra con éxito, redirigimos con un estado de éxito
        header("Location: index.php?status=deleted");
        exit(); // Detenemos la ejecución del script
    } else {
        // Si falla el borrado en la base de datos
        header("Location: index.php?status=error");
        exit();
    }

} else {
    // Si alguien intenta entrar a este archivo sin mandar un ID por la URL
    header("Location: index.php");
    exit();
}
?>