<?php
class Controlador
{
    public function verPagina($ruta)
    {
        require_once $ruta;
    }

    /* Catalogo */
    public function mostrarCatalogo()
    {
        $gestor = new Gestor();
        $categoria = $gestor->consultarCategorias();
        $productos = $gestor->consultarProductos();

        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $por_pagina = 5;
        $offset = ($pagina - 1) * $por_pagina;
        $total_productos = $gestor->contarProductos();
        $total_paginas = ceil($total_productos / $por_pagina);

        $productos = $gestor->consultarProductosPaginados($offset, $por_pagina);

        require 'Vista/html/catalogo.php';
    }

    public function filtrarCategorias($id_categoria)
    {
        $gestor = new Gestor();
        $categoria = $gestor->consultarCategorias();

        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $por_pagina = 5;
        $offset = ($pagina - 1) * $por_pagina;

        if (empty($id_categoria)) {
            $total_productos = $gestor->contarProductos();
            $productos = $gestor->consultarProductosPaginados($offset, $por_pagina);
        } else {
            $total_productos = $gestor->contarProductosPorCategoria($id_categoria);
            $productos = $gestor->consultarProductosPorCategoriaPaginados($id_categoria, $offset, $por_pagina);
        }
        $total_paginas = ceil($total_productos / $por_pagina);

        require 'Vista/html/catalogo.php';
    }
    /* Fin Catalogo */

    /* Verificar sesion */
    public function requireLogin()
    {
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit();
        }
    }
    /* Fin Verificar sesion */

    /* Login Admin */
    public function procesarLogin($correo, $password)
    {
        $gestor = new Gestor();
        $result = $gestor->validarLogin($correo, $password);
        $usuario = $result->fetch_object();

        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php?accion=mostrarAdminProductos");
            exit;
        } else {
            header("Location: index.php?accion=login&error=1");
            exit;
        }
    }
    /* Fin Login Admin */

    /* Login Cliente */
    public function procesarLoginCliente($correo, $password)
    {
        $gestor = new Gestor();
        $usuario = $gestor->buscarUsuarioCliente($correo, $password);
        if ($usuario) {
            $_SESSION['cliente'] = $usuario;
            header("Location: index.php");
            exit;
        } else {
            header("Location: index.php?accion=mostrarLoginCliente&error=1");
            exit;
        }
    }
    /* Fin Login Cliente */

    /* Productos */
    public function mostrarProductos()
    {
        $gestor = new Gestor();
        $productos = $gestor->consultarProductos();
        require 'Vista/html/admin/productos.php';
    }

    public function mostrarAgregarProducto()
    {
        $gestor = new Gestor();
        $categorias = $gestor->consultarcategorias();
        require 'Vista/html/admin/agregarProductos.php';
    }

    public function agregarProducto($nombre, $marca, $modelo, $tipo, $especificaciones, $precio, $categoria, $imagenes)
    {
        $producto = new Productos($nombre, $marca, $modelo, $tipo, $especificaciones, $precio, $categoria);
        $gestor = new Gestor();
        $id_producto = $gestor->agregarProducto($producto);

        $ruta_destino = "Uploads/";
        $extensiones = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];
        $max_tamanyo = 1024 * 1024 * 8; // 8MB

        $total = count($imagenes['name']);
        for ($i = 0; $i < $total; $i++) {
            $nombre_imagen = basename($imagenes['name'][$i]);
            $tipo = $imagenes['type'][$i];
            $tamano = $imagenes['size'][$i];
            $tmp_name = $imagenes['tmp_name'][$i];
            $ruta_final = $ruta_destino . uniqid() . '_' . $nombre_imagen;

            if (in_array($tipo, $extensiones) && $tamano < $max_tamanyo) {
                if (move_uploaded_file($tmp_name, $ruta_final)) {
                    $imagenObj = new Imagenes($id_producto, $ruta_final);
                    $gestor->agregarImagenProducto($imagenObj);
                }
            }
        }

        header("Location: index.php?accion=mostrarAdminProductos");
        exit;
    }

    public function mostrarEditarProducto($id)
    {
        $gestor = new Gestor();
        $producto = $gestor->consultarProductoPorId($id);
        $categorias = $gestor->consultarCategorias();
        $imagenes = $gestor->consultarImagenesProducto($id);
        require 'Vista/html/admin/editarProductos.php';
    }

    public function editarProductos($post, $files)
    {
        $id = $post['id'];
        $nombre = $post['nombre'];
        $marca = $post['marca'];
        $modelo = $post['modelo'];
        $tipo = $post['tipo'];
        $especificaciones = $post['especificaciones'];
        $precio = $post['precio'];
        $categoria = $post['categoria'];

        $gestor = new Gestor();

        /* 1. Actualizar datos del producto */
        $gestor->editarProductos($id, $nombre, $marca, $modelo, $tipo, $especificaciones, $precio, $categoria);

        /* 2. Agregar nuevas imagenes */
        $imagenes = $files['imagenes'];
        $ruta_destino = "Uploads/";
        $extensiones = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];
        $max_tamanyo = 1024 * 1024 * 8;

        if (!empty($imagenes['name'][0])) {
            $total = count($imagenes['name']);
            for ($i = 0; $i < $total; $i++) {
                $nombre_imagen = basename($imagenes['name'][$i]);
                $tipo_img = $imagenes['type'][$i];
                $tamano = $imagenes['size'][$i];
                $tmp_name = $imagenes['tmp_name'][$i];
                $ruta_final = $ruta_destino . uniqid() . '_' . $nombre_imagen;

                if (in_array($tipo_img, $extensiones) && $tamano < $max_tamanyo) {
                    if (move_uploaded_file($tmp_name, $ruta_final)) {
                        $imagenObj = new Imagenes($id, $ruta_final);
                        $gestor->agregarImagenProducto($imagenObj);
                    }
                }
            }
        }

        header("Location: index.php?accion=mostrarAdminProductos");
        exit;
    }

    public function eliminarProductos($id)
    {
        $gestor = new Gestor();
        $producto = $gestor->consultarProductoPorId($id);
        if ($producto && file_exists($producto->imagen)) {
            unlink($producto->imagen);
        }
        $gestor->eliminarProductos($id);
        header("Location: index.php?accion=mostrarAdminProductos");
        exit;
    }

    public function mostrarImagenesProductos() {
        $gestor = new Gestor();
        $id_producto = $_GET['id'];
        $imagenes = $gestor->consultarImagenesProductos($id_producto);
        require 'Vista/html/admin/imagenesProductos.php';
    }

    public function eliminarImagen($id_imagen, $id_producto) {
        $gestor = new Gestor();
        $gestor->eliminarImagenProducto($id_imagen);
        header("Location: index.php?accion=mostrarImagenesProducto&id=$id_producto");
        exit;
    }
    /* Fin Productos */

    /* Categorias */
    public function mostrarCategorias()
    {
        $gestor = new Gestor();
        $categorias = $gestor->consultarCategorias();
        require 'Vista/html/admin/categorias.php';
    }

    public function agregarCategorias($post)
    {
        $nombre = $post['nombre'];
        $categoria = new Categorias($nombre);
        $gestor = new Gestor();
        $gestor->agregarCategorias($categoria);
        header("Location: index.php?accion=mostrarAdminCategorias");
        exit;
    }

    public function eliminarCategorias($id)
    {
        $gestor = new Gestor();
        $gestor->eliminarCategorias($id);
        header("Location: index.php?accion=mostrarAdminCategorias");
        exit;
    }

    public function mostrarEditarCategoria($id)
    {
        $gestor = new Gestor();
        $categoria = $gestor->consultarCategoriaPorId($id);
        require 'Vista/html/admin/editarCategorias.php';
    }

    public function editarCategoria($post)
    {
        $id = $post['id'];
        $nombre = $post['nombre'];
        $gestor = new Gestor();
        $gestor->editarCategoria($id, $nombre);
        header("Location: index.php?accion=mostrarAdminCategorias");
        exit;
    }
    /* Fin Categorias */

    /* Pedidos */
    public function mostrarPedidos()
    {
        $gestor = new Gestor();
        $pedidos = $gestor->consultarPedidos();
        require 'Vista/html/admin/pedidos.php';
    }

    public function mostrarFormularioPedido($id_producto)
    {
        $gestor = new Gestor();
        $producto = $gestor->consultarProductoPorId($id_producto);
        require 'Vista/html/solicitarPedido.php';
    }

    public function guardarPedido($post)
    {
        $correo = $post['correo'];
        $password = $post['password'];
        $id_producto = $post['id_producto'];
        $cantidad = $post['cantidad'];

        $gestor = new Gestor();
        $usuario = $gestor->buscarUsuarioCliente($correo, $password);
        if ($usuario) {
            $gestor->guardarPedido($usuario->id, $id_producto, $cantidad);
            header("Location: index.php?mensaje=pedido_ok");
            exit;
        } else {
            header("Location: index.php?mensaje=usuario_no_encontrado");
            exit;
        }
    }

    public function cambiarEstadoPedido($post)
    {
        $id_pedido = $post['id_pedido'];
        $nuevo_estado = $post['estado'];
        $gestor = new Gestor();
        $gestor->actualizarEstadoPedido($id_pedido, $nuevo_estado);
        header("Location: index.php?accion=mostrarAdminPedidos");
        exit;
    }
    /* Fin Pedidos */

    /* Registro */
    public function mostrarRegister()
    {
        $gestor = new Gestor();
        require 'Vista/html/registroCliente.php';
    }

    public function registrarUsuario($post)
    {
        $nombre = $post['nombre'];
        $correo = $post['correo'];
        $password = $post['password'];
        $rol = 'cliente';

        $gestor = new Gestor();
        $gestor->registrarUsuario($nombre, $correo, $password, $rol);
        header("Location: index.php");
        exit;
    }
    /* Fin registro */

    /* Dashboard */
    public function mostrarDashboard()
    {
        $gestor = new Gestor();
        $productoMasVendido = $gestor->consultarProductoMasVendido();
        require 'Vista/html/admin/dashboard.php';
    }
    /* Fin Dashboard */

    /* Carrito */
    public function agregarAlCarrito($id_producto)
    {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]++;
        } else {
            $_SESSION['carrito'][$id_producto] = 1;
        }
        header("Location: index.php?accion=verCarrito");
        exit;
    }

    public function verCarrito()
    {
        $gestor = new Gestor();
        $carrito = [];
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
                $producto = $gestor->consultarProductoPorId($id_producto);
                if ($producto) {
                    $producto->cantidad = $cantidad;
                    $carrito[] = $producto;
                }
            }
        }
        require 'Vista/html/carrito.php';
    }

    public function quitarDelCarrito($id_producto)
    {
        if (isset($_SESSION['carrito'][$id_producto])) {
            unset($_SESSION['carrito'][$id_producto]);
        }
        header("Location: index.php?accion=verCarrito");
        exit;
    }
    public function confirmarPedidoCarrito($post)
    {
        $correo = $post['correo'];
        $password = $post['password'];
        $gestor = new Gestor();
        $usuario = $gestor->buscarUsuarioCliente($correo, $password);
        if ($usuario && isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
                $gestor->guardarPedido($usuario->id, $id_producto, $cantidad);
            }
            unset($_SESSION['carrito']);
            header("Location: index.php?mensaje=pedido_ok");
            exit;
        } else {
            header("Location: index.php?accion=verCarrito&mensaje=usuario_no_encontrado");
            exit;
        }
    }
    /* fin del carrito */
}
