<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="Vista/css/styles.css">
</head>
<body>
  <header>
    <h1>Dashboard Admin</h1>
    <nav>
      <a href="index.php?accion=mostrarAdminProductos">Productos</a>
      <a href="index.php?accion=mostrarAdminCategorias">Categorias</a>
      <a href="index.php?accion=mostrarAdminPedidos">Pedidos</a>
      <a href="index.php?accion=dashboard">Dashboard</a>
      <a href="index.php?accion=cerrarSesion">Cerrar sesión</a>
    </nav>
  </header>
  <section>
    <h2>Producto más vendido</h2>
    <div style="width:1100px; margin:auto;">
      <canvas id="graficaProductos"></canvas>
    </div>
    <script>
      const ctx = document.getElementById('graficaProductos').getContext('2d');
      const labels = [
        <?php echo $productoMasVendido ? "'"($productoMasVendido->nombre)."'" : "'Sin datos'"; ?>
      ];
      const data = {
        labels: labels,
        datasets: [{
          label: 'Unidades Vendidas',
          data: [
            <?php echo $productoMasVendido ? $productoMasVendido->total_vendidos : 0; ?>
          ],
          backgroundColor: ['#36a2eb']
        }]
      };

      new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
          responsive: true,
          plugins: {
            legend: { display: false }
          }
        }
      });
    </script>
  </section>
</body>
</html>