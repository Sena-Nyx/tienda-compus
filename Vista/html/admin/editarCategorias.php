<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Categoría</title>
  <link rel="stylesheet" href="Vista/css/styles.css">
</head>
<body>
  <header>
    <h1>Editar Categoría</h1>
  </header>
  <section>
    <form action="index.php?accion=editarCategoria" method="post">
      <input type="hidden" name="id" value="<?php echo $categoria->id; ?>">
      <input type="text" name="nombre" value="<?php echo $categoria->nombre; ?>" required>
      <button type="submit">Guardar Cambios</button>
    </form>
  </section>
</body>
</html>