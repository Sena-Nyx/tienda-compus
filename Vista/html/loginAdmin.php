
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
      <a href="index.php">Inicio</a>
      <a href="#catalogo">Catálogo</a>
      <a href="index.php?accion=mostrarLoginAdmin">Zona Admin</a>
      <a href="index.php?accion=mostrarLoginCliente">Login</a>
      <a href="index.php?accion=verCarrito">Ver Carrito</a>
    </nav>
  </header>

  <section id="admin">
    <h2>Zona Administrador</h2>
    <form action="index.php?accion=procesarLogin" method="post">
      <p><strong>Iniciar sesión:</strong></p>
      <input type="email" name="correo" placeholder="Correo" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <button type="submit">Ingresar</button>
    </form>
  </section>

  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
</body>

</html>