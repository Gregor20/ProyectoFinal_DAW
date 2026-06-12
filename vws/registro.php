<?php
// MUY IMPORTANTE: Iniciar la sesión siempre al principio del documento
session_start();

// 1. INCLUDES
include '../config/db.php';
include '../includes/Usuario.php';
include '../includes/header.php';
// Inlcuimos el css específico para esta página
echo '<link rel="stylesheet" href="../assets/css/estilos.css">';

// 2. PROCESAR EL FORMULARIO
$mensaje = "";
if (isset($_POST['registro'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuarioObj = new Usuario($conexion);
    $resultado = $usuarioObj->registrar($nombre, $email, $password);

    if ($resultado === "exito") {
        $mensaje = "<p class='exito' style='background-color: #d4af37; color: #000; border: none;'>¡Bienvenido a Moda 2026! Tu registro se ha completado. Ya puedes iniciar sesión.</p>";
    } elseif ($resultado === "email_duplicado") {
        $mensaje = "<p class='error' style='background-color: #330000; color: #ff6666; border-color: #ff6666;'>Este correo electrónico ya está registrado.</p>";
    } else {
        $mensaje = "<p class='error'>Hubo un problema al crear tu cuenta. Inténtalo más tarde.</p>";
    }
}
?>

<div class="container-crear">
    <h1>Crea tu cuenta</h1>
    
    <?php echo $mensaje; ?>

    <form action="registro.php" method="POST">
        <label>Nombre completo:</label>
        <input type="text" name="nombre" placeholder="Ej: María García" required />

        <label>Correo electrónico:</label>
        <input type="email" name="email" placeholder="tu@email.com" required />

        <label>Contraseña:</label>
        <input type="password" name="password" placeholder="Mínimo 6 caracteres" required minlength="6" />

        <button type="submit" name="registro" class="btn-crear">Registrarse</button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <span style="color: var(--texto-mutado); font-size: 14px;">¿Ya tienes una cuenta?</span>
        <br>
        <a href="login.php" style="color: var(--dorado); text-decoration: none; font-weight: bold;">Inicia sesión aquí</a>
    </div>
</div>

<?php
include '../includes/footer.php';
?>