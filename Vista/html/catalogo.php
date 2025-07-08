<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda de Computadores</title>
  <link rel="stylesheet" href="Vista/css/styles.css">
</head>

<body>
  <header>
    <h1>Tienda de Computadores</h1>
    <nav>
      <a href="index.php">Inicio</a>
      <a href="#catalogo">Catálogo</a>
      <a href="index.php?accion=mostrarLoginAdmin">Zona Admin</a>
      <a href="index.php?accion=mostrarLoginCliente">Login</a>
      <a href="index.php?accion=verCarrito">Ver Carrito</a>
    </nav>
  </header>

  <section id="catalogo">
    <div>
      <h2>Catálogo de Productos</h2>
      <div class="filtro-categorias">
        <form method="get" action="index.php" style="display:inline;">
          <input type="hidden" name="accion" value="filtrarCategorias">
          <label><strong>Categorias:</strong></label>
          <select name="categoria" id="categoria" onchange="this.form.submit()">
            <option value="">Todas</option>
            <?php
            while ($cat = $categoria->fetch_object()) {
              echo "<option value='{$cat->id}'";
              if (isset($_GET['categoria']) && $_GET['categoria'] == $cat->id) {
                echo "selected";
              }
              echo ">{$cat->nombre}</option>";
            }
            ?>
          </select>
        </form>
      </div>
    </div>
    <br>
    <div class="productos">
      <?php if (isset($productos)) { ?>
        <?php while ($prod = $productos->fetch_object()) { ?>
          <div class="producto">
            <img src="<?php echo ($prod->imagen); ?>" alt="<?php echo ($prod->nombre); ?>">
            <h3><?php echo ($prod->nombre); ?></h3>
            <p> <b>Marca:</b> <br> <?php echo ($prod->marca); ?></p>
            <p> <b>Modelo:</b> <br> <?php echo ($prod->modelo); ?></p>
            <p> <b>Especificaciones:</b> <br> <?php echo ($prod->especificaciones); ?></p>
            <p>$<?php echo number_format($prod->precio, 0, ',', '.'); ?></p>
            <form class="solicitar-ped" action="index.php?accion=agregarAlCarrito" method="post">
              <input type="hidden" name="id_producto" value="<?php echo $prod->id; ?>">
              <button type="submit">Agregar al carrito</button>
            </form>
          </div>
        <?php } ?>
      <?php } else { ?>
        <p>No hay productos disponibles</p>
      <?php } ?>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
</body>

</html>