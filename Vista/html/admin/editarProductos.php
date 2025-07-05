<!-- index.html -->
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
      <?php if (isset($_SESSION['usuario'])): ?>
        <span class="usuario-nombre"><?php echo ($_SESSION['usuario']->nombre); ?></span>
      <?php endif; ?>
    </nav>
  </header>

  <section id="panel-admin">
    <h2>Panel de Administración</h2>

    <div class="admin-section">
      <h2>Editar Productos</h2>
      <form class="form-admin" action="index.php?accion=editarProducto" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $producto->id; ?>">
        <input type="text" name="nombre" placeholder="Nombre del producto" value="<?php echo $producto->nombre; ?>" required>
        <input type="text" name="marca" placeholder="Marca" value="<?php echo $producto->marca; ?>" required>
        <input type="text" name="modelo" placeholder="Modelo" value="<?php echo $producto->modelo; ?>" required>
        <input type="text" name="tipo" placeholder="Tipo" value="<?php echo $producto->tipo; ?>" required>
        <input type="text" name="especificaciones" placeholder="Especificaciones" value="<?php echo $producto->especificaciones; ?>" required>
        <input type="number" name="precio" placeholder="Precio" value="<?php echo $producto->precio; ?>" required>
        <select name="categoria" required>
          <option value="">Seleccionar categoría</option>
          <?php
            if(isset($categorias)){
              while($cat = $categorias->fetch_object()){
                $selected = ($cat->id == $producto->id_categoria) ? "selected" : "";
                echo "<option value='{$cat->id}' $selected>{$cat->nombre}</option>";
              }
            }
          ?>
        </select>
        <p>Imágenes actuales:</p>
        <div style="display:flex;gap:10px;">
          <?php
          if (isset($imagenes)) {
              while ($img = $imagenes->fetch_object()) {
          ?>
              <div>
                  <img src="<?php echo $img->imagen; ?>" width="60"><br>
                  <input type="checkbox" name="eliminar_imagenes[]" value="<?php echo $img->id; ?>"> Eliminar
              </div>
          <?php
              }
          }
          ?>
        </div>
        <br>
        <label>Agregar nuevas imágenes:</label>
        <input type="file" name="imagenes[]" multiple>
        <button type="submit">Editar Producto</button>
      </form>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
</body>
</html>


