<?php
class cliente {
    // Propiedades públicas del cliente
    public $idCliente;
    public $nombreCliente;
    public $apellidoCliente;
    public $correoCliente;
    public $contrasenaCliente;
    public $rol;

    // Método para agregar un nuevo cliente
    function agregar() {
        $conet = new Conexion();                   // Crear nueva conexión
        $c = $conet->conectando();                 // Conectarse a la base de datos

        // Verificar si el correo ya existe en la base de datos
        $query = "SELECT * FROM cliente WHERE correoCliente = ?";
        $stmt = $c->prepare($query);
        $stmt->bind_param("s", $this->correoCliente);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // El cliente ya existe
            echo '<script>Swal.fire({
                position: "top",
                icon: "info",
                title: "El Registro ya Existe en el Sistema",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        } else {
            // Encriptar la contraseña
            $contrasenaCliente = password_hash($this->contrasenaCliente, PASSWORD_DEFAULT);

            // Asignar rol por defecto si no se ha definido
            $this->rol = $this->rol ?? 'usuario';

            // Insertar nuevo cliente
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

    // Método para modificar un cliente existente
    function modificar() {
        $c = new Conexion();                       // Crear nueva conexión
        $cone = $c->conectando();                  // Conectarse a la base de datos

        // Verificar si el cliente existe mediante su ID
        $sql = "SELECT * FROM cliente WHERE idCliente = ?";
        $stmt = $cone->prepare($sql);
        $stmt->bind_param("i", $this->idCliente);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // El cliente no existe
            echo '<script>Swal.fire({
                icon: "info",
                title: "El Registro a Modificar no Existe en el Sistema",
                showConfirmButton: false,
                timer: 3000
            });</script>';
        } else {
            // Obtener datos actuales del cliente
            $clienteActual = $result->fetch_assoc();

            // Rol por defecto si está vacío
            $this->rol = empty($this->rol) ? 'usuario' : $this->rol;

            // Convertir 'admin' a 'administrador'
            $this->rol = ($this->rol == 'admin') ? 'administrador' : $this->rol;

            // Encriptar la contraseña solo si se proporciona una nueva
            $contrasenaCliente = empty($this->contrasenaCliente) 
                ? $clienteActual['contrasenaCliente'] 
                : password_hash($this->contrasenaCliente, PASSWORD_DEFAULT);

            // Actualizar el registro del cliente
            $sql = "UPDATE cliente SET
                        nombreCliente = ?,
                        apellidoCliente = ?,
                        correoCliente = ?,
                        contrasenaCliente = ?,
                        rol = ?
                    WHERE idCliente = ?";
            $stmt = $cone->prepare($sql);
            $stmt->bind_param("sssssi", 
                $this->nombreCliente, 
                $this->apellidoCliente, 
                $this->correoCliente, 
                $contrasenaCliente, 
                $this->rol, 
                $this->idCliente);

            if($stmt->execute()) {
                echo '<script>Swal.fire({
                    position: "top",
                    icon: "success",
                    title: "El Registro Fue Actualizado en el Sistema",
                    showConfirmButton: false,
                    timer: 3000
                });</script>';
            } else {
                echo '<script>Swal.fire({
                    position: "top",
                    icon: "error",
                    title: "Error al actualizar el registro",
                    showConfirmButton: false,
                    timer: 3000
                });</script>';
            }
        }
    }

    // Método para eliminar un cliente
    function eliminar() {
        $c = new Conexion();
        $cone = $c->conectando();
        
        // 1. Reasignar préstamos a ID 50
        $cone->query("UPDATE prestamo SET id_cliente = 50 WHERE id_cliente = $this->idCliente");
        
        // 2. Eliminar cliente
        return $cone->query("DELETE FROM cliente WHERE idCliente = $this->idCliente");
    }
}
    
?>
