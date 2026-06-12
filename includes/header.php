<?php
// Nos aseguramos de que la sesión esté iniciada para poder leerla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Configura aquí el nombre exacto de la carpeta de tu proyecto en XAMPP
// Esto evita que los enlaces se rompan al navegar entre carpetas
$base_url = "http://localhost/moda_shop"; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODA 2026 | Boutique Exclusiva</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/estilos.css">
</head>
<body>
    <header>
        <nav class="barra_navegacion">
            <div class="logo">MODA 2026</div>
            <ul class="nav-links">
                <li><a href="<?php echo $base_url; ?>/index.php">Inicio</a></li>
                <li><a href="<?php echo $base_url; ?>/vws/catalogo.php">Productos</a></li>
                
                <?php if(isset($_SESSION['usuario_id'])): ?>
                    <?php if($_SESSION['usuario_rol'] == 1): ?>
                        <li><a href="<?php echo $base_url; ?>/admin/index.php" style="color: var(--dorado); font-weight: bold;">Panel Admin</a></li>
                    <?php endif; ?>

                    <li><a href="<?php echo $base_url; ?>/vws/carrito.php">Mi Carrito</a></li>
                    <li><a href="<?php echo $base_url; ?>/vws/perfil.php" style="color: var(--dorado); font-style: italic;">Hola, <?php echo $_SESSION['usuario_nombre']; ?></a></li>                    <li><a href="<?php echo $base_url; ?>/logout.php" class="btn-login">Cerrar Sesión</a></li>

                <?php else: ?>
                    <li><a href="<?php echo $base_url; ?>/vws/contacto.php">Contacto</a></li>
                    <li><a href="<?php echo $base_url; ?>/vws/login.php" class="btn-login">Iniciar Sesión / Registro</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>