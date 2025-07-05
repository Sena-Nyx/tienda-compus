<?php
session_start();

require_once 'Controlador/Controlador.php';
require_once 'Modelo/Conexion.php';
require_once 'Modelo/Productos.php';
require_once 'Modelo/Imagenes.php';
require_once 'Modelo/Categorias.php';
require_once 'Modelo/Gestor.php';

$controlador = new Controlador();

if (isset($_GET["accion"])) {

    if ($_GET["accion"] == "mostrarLoginAdmin"){
        $controlador->verPagina('Vista/html/loginAdmin.php');
    }

    elseif ($_GET["accion"] == "procesarLogin"){
        $controlador->procesarLogin($_POST["correo"], $_POST["password"]);
    }

    elseif ($_GET["accion"] == "mostrarLoginCliente") {
        $controlador->verPagina('Vista/html/loginCliente.php');
    }

    elseif ($_GET["accion"] == "mostrarRegistroCliente") {
        $controlador->verPagina('Vista/html/registroCliente.php');
    }

    elseif ($_GET["accion"] == "registrarUsuario") {
        $controlador->registrarUsuario($_POST);
    }

    elseif ($_GET["accion"] == "procesarLoginCliente") {
        $controlador->procesarLoginCliente($_POST["correo"], $_POST["password"]);
    }

    elseif ($_GET["accion"] == "mostrarAdminProductos"){
        $controlador->requireLogin();
        $controlador->mostrarProductos();
    }

    elseif ($_GET["accion"] == "mostrarAgregarProducto") {
        $controlador->requireLogin();
        $controlador->mostrarAgregarProducto();
    }

    elseif ($_GET["accion"] == "agregarProducto") {
        $controlador->requireLogin();
        $controlador->agregarProducto(
            $_POST["nombre"],
            $_POST["marca"],
            $_POST["modelo"],
            $_POST["tipo"],
            $_POST["especificaciones"],
            $_POST["precio"],
            $_POST["categoria"],
            $_FILES["imagenes"]); 
    }

    elseif ($_GET["accion"] == "mostrarEditarProducto") {
        $controlador->requireLogin();
        $controlador->mostrarEditarProducto($_GET["id"]);
    }

    elseif ($_GET["accion"] == "editarProducto") {
        $controlador->requireLogin();
        $controlador->editarProductos($_POST, $_FILES);
    }

    elseif ($_GET["accion"] == "eliminarProducto") {
        $controlador->requireLogin();
        $controlador->eliminarProductos($_GET["id"]);
    }

    elseif ($_GET["accion"] == "mostrarAdminCategorias"){
        $controlador->requireLogin();
        $controlador->mostrarCategorias();
    }

    elseif ($_GET["accion"] == "agregarCategoria") {
        $controlador->requireLogin();
        $controlador->agregarCategorias($_POST);
    }

    elseif ($_GET["accion"] == "eliminarCategoria") {
        $controlador->requireLogin();
        $controlador->eliminarCategorias($_GET["id"]);
    }

    elseif ($_GET["accion"] == "mostrarEditarCategoria") {
        $controlador->requireLogin();
        $controlador->mostrarEditarCategoria($_GET["id"]);
    }

    elseif ($_GET["accion"] == "editarCategoria") {
        $controlador->requireLogin();
        $controlador->editarCategoria($_POST);
    }

    elseif ($_GET["accion"] == "mostrarAdminPedidos"){
        $controlador->requireLogin();
        $controlador->mostrarPedidos();
    }

    elseif ($_GET["accion"] == "solicitarPedido") {
        $controlador->mostrarFormularioPedido($_POST["id_producto"]);
    }

    elseif ($_GET["accion"] == "guardarPedido") {
        $controlador->guardarPedido($_POST);
    }

    elseif ($_GET["accion"] == "cambiarEstadoPedido") {
        $controlador->requireLogin();
        $controlador->cambiarEstadoPedido($_POST);
    }

    elseif ($_GET["accion"] == "cerrarSesion") {
        session_destroy();
        header("Location: index.php");
        exit;
    }

    elseif ($_GET["accion"] == "filtrarCategorias") {
        $controlador->filtrarCategorias(
            $_GET["categoria"]);
    }

    elseif ($_GET["accion"] == "dashboard") {
        $controlador->requireLogin();
        $controlador->mostrarDashboard();
    }
}

else {
    $controlador->mostrarCatalogo();
}
?>