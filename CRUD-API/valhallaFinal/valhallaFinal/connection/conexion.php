<?php
class Conexion{
                private $servidor = "localhost";
                private $usuario ="root";
                private $password = "";
                private $db = "valhalla";
                public function conectando(){	
                                            $con = mysqli_connect(
                                                $this->servidor,
                                                $this->usuario,
                                                $this->password, 
                                                $this->db)or die
                                                ("Error al conectar con el servidor comuniquese con el administrador"); 
                                            return $con;
                                        } 
}
$obj = new Conexion();
if($obj->conectando()){
    echo "";
    }
?>