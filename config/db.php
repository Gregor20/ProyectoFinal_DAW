<?php
// Este archivo se encarga de realizar la conexión a la base de datos
// Incluimos el archivo de configuración para obtener las constantes de conexión
include '../config.php';

// Hacemos referencia a las variables del archivo config.php para establecer la conexión
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(!$conexion){
    die("Error en la conexión!");
}

// Esta función establece el juego de caracteres actual para el cliente
mysqli_set_charset($conexion, "utf8");

?>