<?php
class Productos {

    private $nombre;
    private $marca;
    private $modelo;
    private $tipo;
    private $especificaciones;
    private $precio;
    private $categoria;
    
    public function __construct($nombre, $marca, $modelo, $tipo, $especificaciones, $precio, $categoria){
        $this->nombre = $nombre;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->tipo = $tipo;
        $this->especificaciones = $especificaciones;
        $this->precio = $precio;
        $this->categoria = $categoria;
    }

    public function obtenerNombre(){
        return $this->nombre;
    }

    public function obtenerMarca(){
        return $this->marca;
    }

    public function obtenerModelo(){
        return $this->modelo;
    }

    public function obtenerTipo(){
        return $this->tipo;
    }
    
    public function obtenerEspecificaciones(){
        return $this->especificaciones;
    }

    public function obtenerPrecio(){
        return $this->precio;
    }

    public function obtenerCategoria(){
        return $this->categoria;
    }
}
?>