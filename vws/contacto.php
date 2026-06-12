<?php
session_start();
include '../config/db.php';
include '../includes/header.php';

$mensaje_exito = '';

// Si el usuario ha pulsado el botón de enviar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizamos los datos para seguridad
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = htmlspecialchars($_POST['email']);
    $mensaje = htmlspecialchars($_POST['mensaje']);
    
    // Aquí podrías hacer un INSERT a una tabla 'mensajes' en tu BD, 
    // pero para el TFG, simular el envío con un mensaje es perfectamente válido.
    $mensaje_exito = "¡Gracias por escribirnos, <strong>$nombre</strong>! Hemos recibido tu mensaje y nuestro equipo de atención al cliente te responderá muy pronto.";
}
?>

<link rel="stylesheet" href="../assets/css/estilos.css">

<main>
    <div class="container-crear" style="margin-top: 80px; margin-bottom: 80px;">
        <h1 style="font-family: 'Great Vibes', cursive; font-size: 45px; text-transform: none;">Contáctanos</h1>
        
        <?php if ($mensaje_exito != ''): ?>
            <div style="background-color: rgba(212, 175, 55, 0.1); border: 1px solid var(--dorado); padding: 20px; text-align: center; color: var(--dorado); margin-bottom: 20px; border-radius: 4px;">
                <?php echo $mensaje_exito; ?>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: var(--texto-mutado); margin-bottom: 30px; font-size: 14px;">
                ¿Tienes alguna duda sobre nuestra colección o tu pedido? Escríbenos y te responderemos en menos de 24 horas.
            </p>

            <form action="contacto.php" method="POST">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ej: Laura Gómez" required>

                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="Ej: laura@email.com" required>

                <label for="mensaje">Tu Mensaje</label>
                <textarea id="mensaje" name="mensaje" rows="5" placeholder="¿En qué podemos ayudarte?" required></textarea>

                <button type="submit" class="btn-crear">Enviar Mensaje</button>
            </form>
        <?php endif; ?>
    </div>
</main>

<?php
include '../includes/footer.php';
?>