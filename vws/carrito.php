<?php
session_start();

// 1. INCLUDES
include '../config/db.php';
include '../includes/Producto.php';
include '../includes/header.php';

// 2. INICIALIZAR EL CARRITO EN MEMORIA
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array(); // Creamos un array vacío si no existe
}

// 3. LÓGICA DE ACCIONES (Agregar, Eliminar, Vaciar)
if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];

    // AGREGAR: Recibe el ID desde el botón del catálogo
    if ($accion == 'agregar' && isset($_GET['id'])) {
        $id_producto = intval($_GET['id']);
        
        // Si el producto ya está en el carrito, sumamos 1 a la cantidad
        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]++;
        } else {
            // Si no está, lo añadimos con cantidad 1
            $_SESSION['carrito'][$id_producto] = 1;
        }
        // Limpiamos la URL para evitar que al recargar se vuelva a añadir
        header("Location: carrito.php");
        exit();
    }

    // ELIMINAR UN PRODUCTO
    if ($accion == 'eliminar' && isset($_GET['id'])) {
        $id_producto = intval($_GET['id']);
        unset($_SESSION['carrito'][$id_producto]);
        header("Location: carrito.php");
        exit();
    }

    // VACIAR TODO EL CARRITO
    if ($accion == 'vaciar') {
        $_SESSION['carrito'] = array();
        header("Location: carrito.php");
        exit();
    }
}
?>

<div class="container-crear" style="max-width: 900px;">
    <h1>Tu Bolsa de la Compra</h1>

    <?php if (empty($_SESSION['carrito'])): ?>
        <div style="text-align: center; padding: 40px 0;">
            <p style="color: var(--texto-mutado); font-size: 18px;">Tu carrito está vacío ahora mismo.</p>
            <a href="catalogo.php" class="btn-crear" style="display: inline-block; text-decoration: none; margin-top: 20px;">Volver a la tienda</a>
        </div>
    <?php else: ?>
        <table class="listado-productos" style="width: 100%; text-align: left;">
            <thead>
                <tr>
                    <th style="text-align: left;">Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $productoObj = new Producto($conexion);
                $total_pedido = 0;

                // Recorremos el carrito en memoria (ID_Producto => Cantidad)
                foreach ($_SESSION['carrito'] as $id => $cantidad) {
                    // Vamos a la BD a buscar el nombre y el precio real para que no nos engañen
                    $datos = $productoObj->obtenerPorId($id);
                    
                    if ($datos) {
                        $subtotal = $datos['precio'] * $cantidad;
                        $total_pedido += $subtotal;
                        ?>
                        <tr>
                            <td style="text-align: left; color: var(--texto-claro);"><?php echo $datos['nombre']; ?></td>
                            <td><?php echo number_format($datos['precio'], 2, ',', '.'); ?> €</td>
                            <td><?php echo $cantidad; ?></td>
                            <td style="color: var(--dorado); font-weight: bold;"><?php echo number_format($subtotal, 2, ',', '.'); ?> €</td>
                            <td>
                                <a href="carrito.php?accion=eliminar&id=<?php echo $id; ?>" style="color: #ff6666; text-decoration: none; font-size: 12px; text-transform: uppercase;">Quitar</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 30px; border-top: 1px solid var(--borde-dorado); padding-top: 20px;">
            <p style="font-size: 16px; color: var(--texto-mutado);">Total a pagar:</p>
            <h2 style="font-size: 32px; margin: 10px 0;"> <?php echo number_format($total_pedido, 2, ',', '.'); ?> € </h2>
            
            <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 20px;">
                <a href="carrito.php?accion=vaciar" class="btn-primary" style="text-decoration: none; font-size: 12px; padding: 12px 20px;">Vaciar Carrito</a>
                
                <?php if(isset($_SESSION['usuario_id'])): ?>
                    <a href="pago.php" class="btn-crear" style="text-decoration: none; padding: 12px 30px;">Tramitar Pedido</a>
                <?php else: ?>
                    <a href="login.php" class="btn-crear" style="text-decoration: none; padding: 12px 30px;">Inicia Sesión para Comprar</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
include '../includes/footer.php';
?>