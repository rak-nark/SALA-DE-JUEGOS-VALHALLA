<?php
class cliente {
    public $idCliente;
    public $nombreCliente;
    public $apellidoCliente;
    public $correoCliente;
    public $contrasenaCliente;
    public $rol;

    function agregar() {
        $conet = new Conexion();
        $c = $conet->conectando();

        // Verificar si el cliente ya existe
        $query = "SELECT * FROM cliente WHERE correoCliente = '$this->correoCliente'";
        $ejecuta = mysqli_query($c, $query);

        if (mysqli_fetch_array($ejecuta)) {
            echo '<script>Swal.fire({
                position: "top",
                icon: "info",
                title: "El Registro ya Existe en el Sistema",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        } else {
            // Encriptar contraseña
            $contrasenaCliente = password_hash($this->contrasenaCliente, PASSWORD_DEFAULT);
			$this->rol = $this->rol ?? 'usuario';

            // Insertar el registro
            $insertar = "INSERT INTO cliente (nombreCliente, apellidoCliente, correoCliente, contrasenaCliente, rol)
                         VALUES (
                             '$this->nombreCliente',
                             '$this->apellidoCliente',
                             '$this->correoCliente',
                             '$contrasenaCliente',
                             '$this->rol'
                         )";
            
            echo $insertar; // Mostrar la consulta para depuración
            mysqli_query($c, $insertar);

            echo '<script>Swal.fire({
                position: "top",
                icon: "success",
                title: "El Registro Fue Almacenado en el Sistema",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        }
    }

    function modificar() {
        $c = new Conexion();
        $cone = $c->conectando();

        // Verificar si el cliente existe
        $sql = "SELECT * FROM cliente WHERE idCliente = '$this->idCliente'";
        $r = mysqli_query($cone, $sql);

        if (mysqli_fetch_array($r)) {
            echo '<script>Swal.fire({
                icon: "info",
                title: "El Registro a Modificar ya Existe en el Sistema",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        } else {
            // Encriptar contraseña
            $contrasenaCliente = password_hash($this->contrasenaCliente, PASSWORD_DEFAULT);

            // Actualizar registro
            $id = "UPDATE cliente SET
                        nombreCliente = '$this->nombreCliente',
                        apellidoCliente = '$this->apellidoCliente',
                        correoCliente = '$this->correoCliente',
                        contrasenaCliente = '$contrasenaCliente',
                        rol = '$this->rol'
                    WHERE idCliente = '$this->idCliente'";
            
            mysqli_query($cone, $id);
            echo $id; // Mostrar la consulta para depuración

            echo '<script>Swal.fire({
                position: "top",
                icon: "success",
                title: "El Registro Fue Actualizado en el Sistema",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        }
    }

    function eliminar() {
        try {
            $c = new Conexion();
            $cone = $c->conectando();

            // Eliminar el registro
            $sql = "DELETE FROM cliente WHERE idCliente = '$this->idCliente'";
            mysqli_query($cone, $sql);
            echo $sql; // Mostrar la consulta para depuración

            echo '<script>Swal.fire({
                position: "top",
                icon: "success",
                title: "El Registro Fue Eliminado del Sistema",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        } catch (Exception $e) {
            echo '<script>Swal.fire({
                position: "top",
                icon: "warning",
                title: "El Registro no se Puede Eliminar Porqué Tiene Datos Relacionados",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        }
    }
}
?>

