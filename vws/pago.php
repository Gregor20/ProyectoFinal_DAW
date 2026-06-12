<?php
session_start();

// 1. SEGURIDAD: Solo usuarios logueados y con carrito lleno
if (!isset($_SESSION['usuario_id']) || empty($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit();
}

include '../config/db.php';
include '../includes/Producto.php';
include '../includes/header.php';
// Inlcuimos el css específico para esta página
echo '<link rel="stylesheet" href="../assets/css/estilos.css">';

$productoObj = new Producto($conexion);
$mensaje = "";
$pedido_completado = false;

// 2. PROCESAR EL PAGO (Simulación)
if (isset($_POST['pagar'])) {
    $id_usuario = $_SESSION['usuario_id'];
    $total_pedido = 0;

    // A) Calculamos el total real consultando la BD de nuevo (Seguridad)
    foreach ($_SESSION['carrito'] as $id_prod => $cantidad) {
        $datos = $productoObj->obtenerPorId($id_prod);
        if ($datos) {
            $total_pedido += ($datos['precio'] * $cantidad);
        }
    }

    // B) Insertamos en la tabla PEDIDOS
    $sql_pedido = "INSERT INTO pedidos (id_usuario, total) VALUES ('$id_usuario', '$total_pedido')";
    
    if (mysqli_query($conexion, $sql_pedido)) {
        // C) Recuperamos el ID del pedido que se acaba de crear
        $id_pedido_nuevo = mysqli_insert_id($conexion);

        // D) Insertamos cada producto en DETALLE_PEDIDOS
        foreach ($_SESSION['carrito'] as $id_prod => $cantidad) {
            $datos = $productoObj->obtenerPorId($id_prod);
            if ($datos) {
                $precio_historico = $datos['precio'];
                $sql_detalle = "INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, precio_unitario) 
                                VALUES ('$id_pedido_nuevo', '$id_prod', '$cantidad', '$precio_historico')";
                mysqli_query($conexion, $sql_detalle);
            }
        }

        // E) Vaciamos el carrito y marcamos el éxito
        $_SESSION['carrito'] = array();
        $pedido_completado = true;
    } else {
        $mensaje = "<p class='error'>Hubo un error al procesar tu pedido. Inténtalo de nuevo.</p>";
    }
}
?>

<div class="container-crear" style="max-width: 600px;">
    <?php if ($pedido_completado): ?>
        <div style="text-align: center; padding: 30px 0;">
            <h1 style="color: var(--dorado); font-size: 40px; margin-bottom: 10px;">¡Gracias por tu compra!</h1>
            <p style="color: var(--texto-claro); font-size: 18px;">Tu pedido se ha procesado correctamente y ya estamos preparándolo.</p>
            <a href="../index.php" class="btn-crear" style="display: inline-block; text-decoration: none; margin-top: 30px;">Volver al Inicio</a>
        </div>
        
    <?php else: ?>
        <h1 style="text-align: center;">Pasarela de Pago Segura</h1>
        <?php echo $mensaje; ?>

        <div style="background-color: #000; padding: 20px; border: 1px solid var(--borde-dorado); border-radius: 4px; margin-bottom: 20px; text-align: center;">
            <p style="color: var(--texto-mutado); margin: 0 0 5px 0;">Total a cargar en tu tarjeta:</p>
            <?php 
                $total_mostrar = 0;
                foreach ($_SESSION['carrito'] as $id => $cant) {
                    $prod = $productoObj->obtenerPorId($id);
                    if($prod) $total_mostrar += ($prod['precio'] * $cant);
                }
            ?>
            <h2 style="margin: 0; font-size: 28px;"><?php echo number_format($total_mostrar, 2, ',', '.'); ?> €</h2>
        </div>

        <form action="pago.php" method="POST">
            <label>Nombre en la tarjeta:</label>
            <input type="text" name="titular" placeholder="Ej: María García" required />

            <label>Número de tarjeta (Simulación):</label>
            <input type="text" name="tarjeta" placeholder="0000 0000 0000 0000" maxlength="19" required />

            <div style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label>Caducidad:</label>
                    <input type="text" name="caducidad" placeholder="MM/AA" maxlength="5" required />
                </div>
                <div style="flex: 1;">
                    <label>CVC:</label>
                    <input type="text" name="cvc" placeholder="123" maxlength="3" required />
                </div>
            </div>

            <button type="submit" name="pagar" class="btn-crear" style="background-color: var(--dorado); color: #000; font-weight: bold; margin-top: 25px;">
                Confirmar y Pagar
            </button>
        </form>
    <?php endif; ?>
</div>

<?php
include '../includes/footer.php';
?>