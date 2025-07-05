<?php
class Categorias {
    private $id;
    private $nombre;

    public function __construct($nombre, $id = null) {
        $this->nombre = $nombre;
        $this->id = $id;
    }

    public function obtenerId() {
        return $this->id;
    }

    public function obtenerNombre() {
        return $this->nombre;
    }
}
?>