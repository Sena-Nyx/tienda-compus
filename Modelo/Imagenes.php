<?php
class Imagenes {
    private $id_producto;
    private $imagen;

    public function __construct($id_producto, $imagen) {
        $this->id_producto = $id_producto;
        $this->imagen = $imagen;
    }

    public function obtenerIdProducto() {
        return $this->id_producto;
    }

    public function obtenerImagen() {
        return $this->imagen;
    }
}
?>