<?php
session_start();

// 1. SEGURIDAD: Solo usuarios logueados pueden ver perfiles
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// 2. INCLUDES
include '../config/db.php';
include '../includes/header.php';

$id_usuario = $_SESSION['usuario_id'];

// 3. OBTENER EL HISTORIAL DE PEDIDOS DEL CLIENTE (Ordenados del más nuevo al más viejo)
$sql_pedidos = "SELECT * FROM pedidos WHERE id_usuario = '$id_usuario' ORDER BY fecha DESC";
$resultado_pedidos = mysqli_query($conexion, $sql_pedidos);
?>

<div class="container-crear" style="max-width: 800px;">
    <h1>Mi Perfil</h1>
    <p style="text-align: center; color: var(--texto-mutado); margin-bottom: 30px;">
        Bienvenido/a, <strong style="color: var(--dorado);"><?php echo $_SESSION['usuario_nombre']; ?></strong>. Aquí puedes revisar tu historial de compras.
    </p>

    <h2 style="font-size: 20px; border-bottom: 1px solid var(--borde-dorado); padding-bottom: 10px; margin-bottom: 20px;">Mis Pedidos</h2>

    <?php if (mysqli_num_rows($resultado_pedidos) > 0): ?>
        <table class="listado-productos" style="width: 100%;">
            <thead>
                <tr>
                    <th>Nº Pedido</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = mysqli_fetch_assoc($resultado_pedidos)): ?>
                    <tr>
                        <td style="color: var(--dorado); font-weight: bold;">#<?php echo str_pad($pedido['id'], 5, "0", STR_PAD_LEFT); ?></td>
                        
                        <td><?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></td>
                        
                        <td><?php echo number_format($pedido['total'], 2, ',', '.'); ?> €</td>
                        
                        <td><span style="background-color: rgba(74, 222, 128, 0.1); color: #4ade80; padding: 4px 8px; border-radius: 4px; font-size: 12px; border: 1px solid #4ade80;">Completado</span></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="text-align: center; padding: 20px;">
            <p style="color: var(--texto-mutado);">Aún no has realizado ninguna compra en nuestra boutique.</p>
            <a href="catalogo.php" class="btn-primary" style="display: inline-block; text-decoration: none; margin-top: 15px; padding: 10px 20px; font-size: 14px;">Ir al catálogo</a>
        </div>
    <?php endif; ?>
</div>

<?php
include '../includes/footer.php';
?>