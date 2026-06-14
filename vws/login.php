<?php
// MUY IMPORTANTE: Iniciar la sesión
session_start();

// 1. INCLUDES
include '../config/db.php';
include '../includes/Usuario.php';
include '../includes/header.php';
// Inlcuimos el css específico para esta página
echo '<link rel="stylesheet" href="../assets/css/estilos.css">';

// 2. PROCESAR EL FORMULARIO
$mensaje = "";
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuarioObj = new Usuario($conexion);
    $user_data = $usuarioObj->login($email, $password);

    if ($user_data) {
        // Credenciales correctas: GUARDAMOS LA SESIÓN
        $_SESSION['usuario_id'] = $user_data['id'];
        $_SESSION['usuario_nombre'] = $user_data['nombre'];
        $_SESSION['usuario_rol'] = $user_data['id_rol'];

        // Redirección inteligente según el rol[cite: 1]
        if ($user_data['id_rol'] == 1) { // 1 = Admin[cite: 1]
            header("Location: ../admin/index.php");
            exit();
        } else { // 2 = Cliente[cite: 1]
            header("Location: ../index.php");
            exit();
        }
    } else {
        $mensaje = "<p class='error'>Correo o contraseña incorrectos.</p>";
    }
}
?>

<div class="container-crear">
    <h1>Iniciar Sesión</h1>
    
    <?php echo $mensaje; ?>

    <form action="login.php" method="POST">
        <label>Correo electrónico:</label>
        <input type="email" name="email" placeholder="tu@email.com" required />

        <label>Contraseña:</label>
        <input type="password" name="password" placeholder="Tu contraseña" required />

        <button type="submit" name="login" class="btn-crear">Entrar</button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <span style="color: var(--texto-mutado); font-size: 14px;">¿No tienes cuenta?</span>
        <br>
        <a href="registro.php" style="color: var(--dorado); text-decoration: none; font-weight: bold;">Regístrate ahora</a>
    </div>
</div>

<?php
include '../includes/footer.php';
?>