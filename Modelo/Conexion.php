<?php
class Conexion {
    private $mySQLI;
    private $sql;
    private $result;
    private $id;

    public function abrir(){
        $this->mySQLI = new mysqli("localhost","root","","tienda_compus");
        if(mysqli_connect_error()){
            return 0;
        } 
        else {
            return 1;
        }
    }

    public function cerrar(){
        $this->mySQLI->close();
    }

    public function consulta($sql){
        $this->sql = $sql;
        $this->result = $this->mySQLI->query($this->sql);
        $this->id = $this->mySQLI->insert_id;
    }

    public function obtenerResult(){
        return $this->result;
    }

    public function obtenerId(){
        return $this->id;
    }
}