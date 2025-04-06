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
        $query = "SELECT * FROM cliente WHERE correoCliente = ?";
        $stmt = $c->prepare($query);
        $stmt->bind_param("s", $this->correoCliente);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
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
                         VALUES (?, ?, ?, ?, ?)";
            $stmt = $c->prepare($insertar);
            $stmt->bind_param("sssss", $this->nombreCliente, $this->apellidoCliente, $this->correoCliente, $contrasenaCliente, $this->rol);
            $stmt->execute();

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
        $sql = "SELECT * FROM cliente WHERE idCliente = ?";
        $stmt = $cone->prepare($sql);
        $stmt->bind_param("i", $this->idCliente);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows == 0) {
            echo '<script>Swal.fire({
                icon: "info",
                title: "El Registro a Modificar no Existe en el Sistema",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        } else {
            // Establecer el rol como 'usuario' si es null
            $this->rol = $this->rol ?? 'usuario';
    
            // Encriptar contraseña solo si se proporciona una nueva
            if (!empty($this->contrasenaCliente)) {
                $contrasenaCliente = password_hash($this->contrasenaCliente, PASSWORD_DEFAULT);
            } else {
                // Mantener la contraseña actual
                $contrasenaCliente = $result->fetch_assoc()['contrasenaCliente'];
            }
    
            // Actualizar registro
            $sql = "UPDATE cliente SET
                        nombreCliente = ?,
                        apellidoCliente = ?,
                        correoCliente = ?,
                        contrasenaCliente = ?,
                        rol = ?
                    WHERE idCliente = ?";
            $stmt = $cone->prepare($sql);
            $stmt->bind_param("sssssi", $this->nombreCliente, $this->apellidoCliente, $this->correoCliente, $contrasenaCliente, $this->rol, $this->idCliente);
            $stmt->execute();
    
            echo '<script>Swal.fire({
                position: "top",
                icon: "success",
                title: "El Registro Fue Actualizado en el Sistema",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        }
    

            // Actualizar registro
            $sql = "UPDATE cliente SET
                        nombreCliente = ?,
                        apellidoCliente = ?,
                        correoCliente = ?,
                        contrasenaCliente = ?,
                        rol = ?
                    WHERE idCliente = ?";
            $stmt = $cone->prepare($sql);
            $stmt->bind_param("sssssi", $this->nombreCliente, $this->apellidoCliente, $this->correoCliente, $contrasenaCliente, $this->rol, $this->idCliente);
            $stmt->execute();

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
            $sql = "DELETE FROM cliente WHERE idCliente = ?";
            $stmt = $cone->prepare($sql);
            $stmt->bind_param("i", $this->idCliente);
            $stmt->execute();

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

?>