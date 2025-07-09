<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda de Computadores</title>
  <link rel="stylesheet" href="Vista/css/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
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
    <?php
    if (!isset($gestor)) {
        $gestor = new Gestor();
    }
    ?>
    <div class="productos">
      <?php if (isset($productos)) { ?>
        <?php while ($prod = $productos->fetch_object()) { ?>
          <div class="producto">
            <!-- Carrusel Bootstrap para imágenes del producto -->
            <?php
              $imagenes = $gestor->consultarImagenesProducto($prod->id);
              $primera = true;
              $hayMasDeUna = ($imagenes->num_rows > 1);
            ?>
            <div id="carousel-<?php echo $prod->id; ?>" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <?php while ($img = $imagenes->fetch_object()){ ?>
                  <div class="carousel-item <?php if($primera){echo 'active'; $primera=false;} ?>">
                    <img src="<?php echo $img->imagen; ?>" class="d-block w-100" style="height:190px;object-fit:cover;" alt="Imagen producto">
                  </div>
                <?php } ?>
              </div>
              <?php if($hayMasDeUna){ ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $prod->id; ?>" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $prod->id; ?>" data-bs-slide="next">
                  <span class="carousel-control-next-icon"></span>
                </button>
              <?php } ?>
            </div>
            <!-- Fin Carrusel -->

            <h3><?php echo ($prod->nombre); ?></h3>
            <p><b>Marca:</b> <br> <?php echo ($prod->marca); ?></p>
            <p><b>Modelo:</b> <br> <?php echo ($prod->modelo); ?></p>
            <p><b>Especificaciones:</b> <br> <?php echo ($prod->especificaciones); ?></p>
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
  </div>
  <!-- Paginación -->
  <div style="text-align:center; margin-top:2rem;">
    <?php if (isset($total_paginas) && $total_paginas > 1): ?>
      <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
        <?php if ($i == $pagina): ?>
          <strong><?php echo $i; ?></strong>
        <?php else: ?>
          <a href="index.php?accion=mostrarCatalogo&pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endif; ?>
      <?php endfor; ?>
    <?php endif; ?>
  </div>
  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
</body>

</html>