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
        
        $sql = "UPDATE consola SET 
                estado = '$this->estado' 
                WHERE id = '$this->id'";
        
        if(mysqli_query($cone, $sql)) {
            echo '<script>Swal.fire("Éxito", "Estado actualizado correctamente", "success");</script>';
            return true;
        } else {
            echo '<script>Swal.fire("Error", "Error al actualizar: '.mysqli_error($cone).'", "error");</script>';
            return false;
        }
    }
    
    function buscarPorTipo($busqueda) {
        $c = new Conexion();
        $cone = $c->conectando();
        $busqueda = mysqli_real_escape_string($cone, $busqueda);
        $query = "SELECT * FROM consola WHERE tipo LIKE '%$busqueda%'";
        $result = mysqli_query($cone, $query);
        return $result;
    }
    function actualizarEstado($idConsola, $estado) {
        $this->id = $idConsola;
        $this->estado = $estado;
        return $this->modificarEstado();
    }
}
?>