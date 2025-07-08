<?php

use PSpell\Config;

class Gestor
{
    public function consultarProductos()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT p.id, p.nombre, p.marca, p.modelo, p.tipo, p.especificaciones, p.precio, c.nombre AS categoria
                FROM productos p
                JOIN categorias c ON p.id_categoria = c.id";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result;
    }

    public function validarLogin($email, $clave)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM usuarios WHERE correo = '$email' AND password = '$clave' AND rol = 'admin'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result;
    }

    public function agregarProducto(Productos $producto)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $nombre = $producto->obtenerNombre();
        $marca = $producto->obtenerMarca();
        $modelo = $producto->obtenerModelo();
        $tipo = $producto->obtenerTipo();
        $especificaciones = $producto->obtenerEspecificaciones();
        $precio = $producto->obtenerPrecio();
        $categoria = $producto->obtenercategoria();
        $sql = "INSERT INTO productos (nombre, marca, modelo, tipo, especificaciones, precio, id_categoria) VALUES ('$nombre', '$marca', '$modelo', '$tipo', '$especificaciones', '$precio', '$categoria')";
        $conexion->consulta($sql);
        $id_producto = $conexion->obtenerId();
        $conexion->cerrar();
        return $id_producto;
    }

    public function consultarImagenesProducto($id_producto)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM imagenes WHERE id_producto = '$id_producto'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    public function eliminarImagenProducto($id_imagen)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT imagen FROM imagenes WHERE id = '$id_imagen'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $img = $result->fetch_object();
        if ($img && file_exists($img->imagen)) {
            unlink($img->imagen);
        }
        $sql = "DELETE FROM imagenes WHERE id = '$id_imagen'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function agregarImagenProducto(Imagenes $imagen)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $id_producto = $imagen->obtenerIdProducto();
        $ruta_imagen = $imagen->obtenerImagen();
        $sql = "INSERT INTO imagenes (id_producto, imagen) VALUES ('$id_producto', '$ruta_imagen')";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function consultarCategorias()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM categorias";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result;
    }

    public function consultarProductoPorId($id)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM productos WHERE id = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result->fetch_object();
    }

    public function consultarProductosPorCategoria($id_categoria)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.imagen, c.nombre AS categoria
                FROM productos p
                JOIN categorias c ON p.id_categoria = c.id
                WHERE p.id_categoria = '$id_categoria'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    public function editarProductos($id, $nombre, $marca, $modelo, $tipo, $especificaciones, $precio, $categoria)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE productos SET nombre='$nombre', marca='$marca', modelo='$modelo', tipo='$tipo', especificaciones='$especificaciones', precio='$precio', id_categoria='$categoria' WHERE id='$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function eliminarProductos($id)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM productos WHERE id='$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function agregarCategorias(Categorias $categoria)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $nombre = $categoria->obtenerNombre();
        $sql = "INSERT INTO categorias (nombre) VALUES ('$nombre')";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function editarCategoria($id, $nombre)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE categorias SET nombre='$nombre' WHERE id='$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function consultarCategoriaPorId($id)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM categorias WHERE id = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result->fetch_object();
    }
    public function eliminarCategorias($id)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM categorias WHERE id='$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function consultarPedidos()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT p.id, u.nombre AS cliente, pr.nombre AS producto, p.cantidad, p.fecha, p.estado
                FROM pedidos p
                JOIN usuarios u ON p.id_usuario = u.id
                JOIN productos pr ON p.id_producto = pr.id";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    public function registrarUsuario($nombre, $correo, $password, $rol)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); /* Hashear la contraseña */
        $sql = "INSERT INTO usuarios (nombre, correo, password, rol) VALUES ('$nombre', '$correo', '$passwordHash', '$rol')";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function buscarUsuarioCliente($correo, $password)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND rol = 'cliente'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        $usuario = $result->fetch_object();
        if ($usuario && password_verify($password, $usuario->password)) {
            return $usuario;
        }
        return false;
    }

    public function guardarPedido($id_usuario, $id_producto, $cantidad)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $fecha = date('Y-m-d H:i:s');
        $estado = 'pendiente';
        $sql = "INSERT INTO pedidos (id_usuario, id_producto, cantidad, fecha, estado) VALUES ('$id_usuario', '$id_producto', '$cantidad', '$fecha', '$estado')";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function actualizarEstadoPedido($id_pedido, $nuevo_estado)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE pedidos SET estado = '$nuevo_estado' WHERE id = '$id_pedido'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function consultarProductoMasVendido()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT pr.nombre, SUM(p.cantidad) AS total_vendidos
                FROM pedidos p
                JOIN productos pr ON p.id_producto = pr.id
                WHERE p.estado = 'entregado'
                GROUP BY pr.id
                ORDER BY total_vendidos DESC
                LIMIT 1";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result->fetch_object();
    }

    //Paginación de productos
    public function consultarProductosPaginados($offset, $limit)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT p.id, p.nombre, p.marca, p.modelo, p.tipo, p.especificaciones, p.precio, c.nombre AS categoria, 
                   (SELECT imagen FROM imagenes WHERE id_producto = p.id LIMIT 1) AS imagen
            FROM productos p
            JOIN categorias c ON p.id_categoria = c.id
            LIMIT $offset, $limit";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    public function contarProductos()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT COUNT(*) as total FROM productos";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $row = $result->fetch_object();
        $conexion->cerrar();
        return $row->total;
    }
}
