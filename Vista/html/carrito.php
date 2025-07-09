<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="Vista/css/styles.css">
</head>

<body>
    <header>
        <h1>Carrito de Compras</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="index.php?accion=mostrarCatalogo">Catálogo</a>
            <a href="index.php?accion=mostrarLoginAdmin">Zona Admin</a>
            <a href="index.php?accion=mostrarLoginCliente">Login</a>
            <a href="index.php?accion=verCarrito">Ver Carrito</a>
        </nav>
    </header>
    <section>
        <h2>Productos en el carrito</h2>
        <?php if (isset($_GET['mensaje'])): ?>
            <div style="color: green; font-weight: bold;">
                <?php echo htmlspecialchars($_GET['mensaje']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div style="color: red; font-weight: bold;">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($carrito)) { ?>
            <div style="display: flex; justify-content: center; margin-bottom: 30px;">
                <table>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                    <?php $total = 0;
                    foreach ($carrito as $prod) {
                        $subtotal = $prod->precio * $prod->cantidad;
                        $total += $subtotal; ?>
                        <tr>
                            <td><?php echo $prod->nombre; ?></td>
                            <td><?php echo $prod->cantidad; ?></td>
                            <td>$<?php echo number_format($prod->precio, 0, ',', '.'); ?></td>
                            <td>$<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                            <td>
                                <a href="index.php?accion=quitarDelCarrito&id_producto=<?php echo $prod->id; ?>">Quitar</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3"><b>Total</b></td>
                        <td colspan="2"><b>$<?php echo number_format($total, 0, ',', '.'); ?></b></td>
                    </tr>
                </table>
            </div>
            <form action="index.php?accion=confirmarPedidoCarrito" method="post">
                <input type="email" name="correo" placeholder="Correo registrado" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Confirmar pedido</button>
            </form>
        <?php } else { ?>
            <p>El carrito está vacío.</p>
        <?php } ?>
    </section>
</body>

</html>