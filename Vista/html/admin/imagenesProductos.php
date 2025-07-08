<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda de Tenis</title>
  <link rel="stylesheet" href="Vista/css/styles.css">
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
      <?php if (isset($_SESSION['usuario'])){ ?>
        <span class="usuario-nombre"><?php echo ($_SESSION['usuario']->nombre); ?></span>
      <?php } ?>
    </nav>
  </header>

  <section id="panel-admin">
    <h2>Panel de Administración</h2>
    <div class="admin-section">
      <h2>Imagenes asociadas</h2>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Imagen</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <?php while($img = $imagenes->fetch_object()) { ?>
          <tbody>
            <tr>
              <td><?php echo $img->id; ?></td>
              <td><img src="<?php echo $img->imagen; ?>" width="120"></td>
              <td>
                <a href="index.php?accion=eliminarImagen&id=<?php echo $img->id; ?>&id_producto=<?php echo $img->id_producto; ?>" onclick="return confirm('¿Seguro que desea eliminar esta imagen?');">
                  <button type="button">Eliminar</button>
                </a>
              </td>
            </tr>
          </tbody>
          <?php } ?>
        </table>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
</body>
</html>


