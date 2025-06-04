<?php
// Elimina el include de conexion.php si ya está en el controlador
class Consola {
    public $id;
    public $tipo;
    public $estado;
    
    function listar() {
        $c = new Conexion();
        $cone = $c->conectando();
        $query = "SELECT * FROM consola";
        $result = mysqli_query($cone, $query);
        return $result;
    }
    
    function modificarEstado() {
        $c = new Conexion();
        $cone = $c->conectando();
        
        // Validaciones
        if(empty($this->id) || !in_array($this->estado, ['disponible', 'no_disponible', 'mantenimiento'])) {
            echo '<script>Swal.fire("Error", "Datos inválidos para la actualización", "error");</script>';
            return false;
        }
        
        // Consulta preparada para evitar inyección SQL
        $sql = "UPDATE consola SET estado = ? WHERE id = ?";
        $stmt = mysqli_prepare($cone, $sql);
        if (!$stmt) {
            echo '<script>Swal.fire("Error", "Error en la preparación de la consulta", "error");</script>';
            return false;
        }
        mysqli_stmt_bind_param($stmt, "si", $this->estado, $this->id);
        if(mysqli_stmt_execute($stmt)) {
            echo '<script>Swal.fire("Éxito", "Estado actualizado correctamente", "success");</script>';
            mysqli_stmt_close($stmt);
            return true;
        } else {
            echo '<script>Swal.fire("Error", "Error al actualizar: '.mysqli_error($cone).'", "error");</script>';
            mysqli_stmt_close($stmt);
            return false;
        }
    }
    
    function buscarPorTipo($busqueda) {
        $c = new Conexion();
        $cone = $c->conectando();
        // Consulta preparada para evitar inyección SQL
        $sql = "SELECT * FROM consola WHERE tipo LIKE ?";
        $stmt = mysqli_prepare($cone, $sql);
        if (!$stmt) {
            return false;
        }
        $param = "%" . $busqueda . "%";
        mysqli_stmt_bind_param($stmt, "s", $param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
    function actualizarEstado($idConsola, $estado) {
        $this->id = $idConsola;
        $this->estado = $estado;
        return $this->modificarEstado();
    }
}
?>