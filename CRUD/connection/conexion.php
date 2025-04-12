<?php
class Conexion {
    private $servidor = "localhost";
    private $usuario = "root";
    private $password = "";
    private $db = "valhalla";
    public function conectando() {	
        $con = mysqli_connect(
            $this->servidor,
            $this->usuario,
            $this->password, 
            $this->db
        ) or die("Error al conectar con el servidor, comuníquese con el administrador");
        return $con;
    } 
}

// Crear una conexión global
$obj = new Conexion();
$conexion = $obj->conectando(); // Se crea la variable $conexion accesible en otros archivos
