<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda de Tenis</title>
  <link rel="stylesheet" href="Vista/css/styles.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <header>
    <h1>Tienda de Tenis</h1>
    <nav>
      <a href="index.php?accion=mostrarAdminProductos">Productos</a>
      <a href="index.php?accion=mostrarAdminCategorias">Categorias</a>
      <a href="index.php?accion=mostrarAdminPedidos">Pedidos</a>
      <a href="index.php?accion=dashboard">Dashboard</a>
      <a href="index.php?accion=cerrarSesion">Cerrar sesión</a>
      <?php if (isset($_SESSION['usuario'])): ?>
        <span class="usuario-nombre"><?php echo ($_SESSION['usuario']->nombre); ?></span>
      <?php endif; ?>
    </nav>
  </header>

  <section id="panel-admin">
    <h2>Panel de Administración</h2>
    <div class="admin-section">
      <h3>Pedidos</h3>
      <table>
        <thead>
          <tr>
            <th>ID Pedido</th>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php if(isset($pedidos)){ ?>
            <?php while($pedido = $pedidos->fetch_object()){ ?>
              <tr>
                <td><?php echo $pedido->id; ?></td>
                <td><?php echo $pedido->cliente; ?></td>
                <td><?php echo $pedido->producto; ?></td>
                <td><?php echo $pedido->cantidad; ?></td>
                <td><?php echo $pedido->fecha; ?></td>
                <td><?php echo $pedido->estado; ?></td>
                <td>
                  <form action="index.php?accion=cambiarEstadoPedido" method="post" style="display:inline;">
                    <input type="hidden" name="id_pedido" value="<?php echo $pedido->id; ?>">
                    <select name="estado">
                      <option value="pendiente" <?php if($pedido->estado == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                      <option value="enviado" <?php if($pedido->estado == 'enviado') echo 'selected'; ?>>Enviado</option>
                      <option value="entregado" <?php if($pedido->estado == 'entregado') echo 'selected'; ?>>Entregado</option>
                      <option value="cancelado" <?php if($pedido->estado == 'cancelado') echo 'selected'; ?>>Cancelado</option>
                    </select> 
                    <button type="submit">Actualizar</button>
                  </form>
                </td>
              </tr>
            <?php } ?>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
</body>
</html>