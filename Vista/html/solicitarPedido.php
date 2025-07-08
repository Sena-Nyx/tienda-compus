<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitar Pedido</title>
  <link rel="stylesheet" href="Vista/css/styles.css">
</head>
<body>
  <header>
    <h1>Tienda de Tenis</h1>
    <nav>
      <a href="index.php">Inicio</a>
      <a href="index.php">Catálogo</a>
      <a href="index.php?accion=mostrarLoginAdmin">Zona Admin</a>
      <a href="index.php?accion=mostrarLoginCliente">Login</a>
    </nav>
  </header>
  <section id="solicitar-pedido">
    <div class="admin-section">
      <h2>Solicitar Pedido</h2>
      <form action="index.php?accion=guardarPedido" method="post">
        <h1><?php echo ($producto->nombre); ?></h1>
        <img src="<?php echo ($producto->imagen); ?>" width="170">
        <p>Categoría: <?php echo ($producto->id_categoria); ?></p>
        <p>Precio: $<?php echo number_format($producto->precio, 0, ',', '.'); ?></p>

        <input type="hidden" name="id_producto" value="<?php echo $producto->id; ?>">
        <input type="number" name="cantidad" placeholder="Cantidad" min="1" required>

        <h4>Datos del cliente</h4>
        <input type="email" name="correo" placeholder="Correo registrado" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Confirmar Pedido</button>
      </form>
    </div>
  </section>
  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
</body>
</html>