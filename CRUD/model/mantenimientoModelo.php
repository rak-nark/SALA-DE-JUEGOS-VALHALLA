<?php
class MantenimientoModelo {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function listar($pagina = 1, $porPagina = 10) {
        $conn = $this->conexion->conectando();
        $desde = ($pagina - 1) * $porPagina;

        $query = "SELECT * FROM mantenimiento 
                 ORDER BY 
                   CASE estado
                     WHEN 'en_proceso' THEN 1
                     WHEN 'pendiente' THEN 2
                     WHEN 'completado' THEN 3
                     ELSE 4
                   END,
                   fecha_programada ASC
                 LIMIT ?, ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $desde, $porPagina);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $mantenimientos = [];
        while ($row = $result->fetch_assoc()) {
            $row['clase_estado'] = $this->determinarClaseEstado($row['estado'], $row['fecha_programada']);
            $mantenimientos[] = $row;
        }

        $stmt->close();
        $conn->close();
        return $mantenimientos;
    }

    public function contar() {
        $conn = $this->conexion->conectando();
        $result = $conn->query("SELECT COUNT(*) as total FROM mantenimiento");
        $row = $result->fetch_assoc();
        $conn->close();
        return (int)$row['total'];
    }

    public function obtenerPorId($id) {
        $conn = $this->conexion->conectando();
        $stmt = $conn->prepare("SELECT * FROM mantenimiento WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $mantenimiento = $result->fetch_assoc();
        
        $stmt->close();
        $conn->close();
        return $mantenimiento;
    }

    public function agregar($data) {
        $conn = $this->conexion->conectando();
        $stmt = $conn->prepare(
            "INSERT INTO mantenimiento 
             (tipo, descripcion, id_consola, fecha_programada) 
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssis",
            $data['tipo'],
            $data['descripcion'],
            $data['id_consola'],
            $data['fecha_programada']
        );
        $result = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        return $result;
    }

    public function actualizar($data) {
        $conn = $this->conexion->conectando();
        $stmt = $conn->prepare(
            "UPDATE mantenimiento 
             SET tipo = ?, descripcion = ?, id_consola = ?, fecha_programada = ?
             WHERE id = ?"
        );
        $stmt->bind_param(
            "ssisi",
            $data['tipo'],
            $data['descripcion'],
            $data['id_consola'],
            $data['fecha_programada'],
            $data['id']
        );
        $result = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        return $result;
    }

    public function cambiarEstado($id, $estado) {
        $conn = $this->conexion->conectando();
        
        switch($estado) {
            case 'iniciar':
                $query = "UPDATE mantenimiento 
                          SET estado = 'en_proceso', fecha_inicio = NOW()
                          WHERE id = ? AND estado = 'pendiente'";
                break;
            case 'completar':
                $query = "UPDATE mantenimiento 
                          SET estado = 'completado', fecha_fin = NOW()
                          WHERE id = ? AND estado = 'en_proceso'";
                break;
            case 'cancelar':
                $query = "UPDATE mantenimiento 
                          SET estado = 'cancelado', fecha_fin = NOW()
                          WHERE id = ? AND estado IN ('pendiente', 'en_proceso')";
                break;
            default:
                return false;
        }
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        return $result;
    }

    public function eliminar($id) {
        $conn = $this->conexion->conectando();
        $stmt = $conn->prepare("DELETE FROM mantenimiento WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        return $result;
    }

    private function determinarClaseEstado($estado, $fechaProgramada) {
        if ($estado === 'completado') return 'completado';
        if ($estado === 'cancelado') return 'cancelado';
        if ($estado === 'en_proceso') return 'en-proceso';

        $hoy = new DateTime();
        $fechaMant = new DateTime($fechaProgramada);

        if ($fechaMant < $hoy) return 'vencido';

        $diferencia = $hoy->diff($fechaMant);
        $dias = $diferencia->days;

        if ($dias <= 3) return 'urgente';
        if ($dias <= 7) return 'proximo';
        return 'programado';
    }
}

?>