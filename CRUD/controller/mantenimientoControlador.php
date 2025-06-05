<?php
include_once '../model/mantenimientoModelo.php';
include_once '../model/consolaModelo.php';

class MantenimientoController {
    private $mantenimientoModel;
    private $consolaModel;

    public function __construct() {
        $this->mantenimientoModel = new MantenimientoModelo();
        $this->consolaModel = new Consola();
    }

    public function handleRequest() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->handlePost();
            } else {
                $this->displayMantenimientos();
            }
        } catch (Exception $e) {
            $this->redirectWithError($e->getMessage());
        }
    }

    private function handlePost() {
        $action = $_POST['action'] ?? '';
        $id = (int)($_POST['id'] ?? 0);

        switch ($action) {
            case 'agregar':
                $this->handleAdd();
                break;
            case 'actualizar':
                $this->handleUpdate();
                break;
            case 'cambiar_estado':
                $this->handleStatusChange($id, $_POST['estado']);
                break;
            case 'eliminar':
                $this->handleDelete($id);
                break;
            default:
                $this->redirectWithError('Acción no válida');
        }
    }
    private function agregarMantenimiento() {
        $requiredFields = ['tipo', 'descripcion', 'id_consola', 'fecha_programada'];
        $this->validatePostData($requiredFields);
    
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'id_consola' => (int)$_POST['id_consola'],
            'fecha_programada' => $_POST['fecha_programada']
        ];
    
        try {
            $success = $this->mantenimientoModel->agregar($data);
            if ($success) {
                // Cambia esta línea para usar el método actualizado
                $this->consolaModel->actualizarEstado($data['id_consola'], 'mantenimiento');
                header("Location: mantenimiento.php?success=Mantenimiento programado correctamente");
                exit;
            }
            header("Location: mantenimiento.php?error=Error al programar el mantenimiento");
            exit;
        } catch (Exception $e) {
            header("Location: mantenimiento.php?error=" . urlencode($e->getMessage()));
            exit;
        }
    }

    private function handleAdd() {
        $this->validateFields(['tipo', 'descripcion', 'id_consola', 'fecha_programada']);
        
        $data = [
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'id_consola' => (int)$_POST['id_consola'],
            'fecha_programada' => $_POST['fecha_programada']
        ];

        if ($this->mantenimientoModel->agregar($data)) {
            $this->consolaModel->actualizarEstado($data['id_consola'], 'mantenimiento');
            $this->redirectWithSuccess('Mantenimiento programado correctamente');
        }
        $this->redirectWithError('Error al programar el mantenimiento');
    }

    private function handleUpdate() {
        $this->validateFields(['id', 'tipo', 'descripcion', 'id_consola', 'fecha_programada']);
        
        $data = [
            'id' => (int)$_POST['id'],
            'tipo' => $_POST['tipo'],
            'descripcion' => $_POST['descripcion'],
            'id_consola' => (int)$_POST['id_consola'],
            'fecha_programada' => $_POST['fecha_programada']
        ];

        if ($this->mantenimientoModel->actualizar($data)) {
            $this->redirectWithSuccess('Mantenimiento actualizado correctamente');
        }
        $this->redirectWithError('Error al actualizar el mantenimiento');
    }

    private function handleStatusChange($id, $estado) {
        try {
            if ($this->mantenimientoModel->cambiarEstado($id, $estado)) {
                $mantenimiento = $this->mantenimientoModel->obtenerPorId($id);
                
                // Actualizar estado de la consola solo si el mantenimiento estaba en proceso
                if ($mantenimiento['estado'] === 'en_proceso' && ($estado === 'completar' || $estado === 'cancelar')) {
                    $this->consolaModel->actualizarEstado($mantenimiento['id_consola'], 'disponible');
                }
                
                $this->redirectWithSuccess("Mantenimiento " . ($estado === 'cancelar' ? 'cancelado' : 'actualizado') . " correctamente");
            } else {
                $this->redirectWithError("No se pudo cambiar el estado del mantenimiento");
            }
        } catch (Exception $e) {
            $this->redirectWithError("Error: " . $e->getMessage());
        }
    }

    private function handleDelete($id) {
        $mantenimiento = $this->mantenimientoModel->obtenerPorId($id);
        
        if ($this->mantenimientoModel->eliminar($id)) {
            if ($mantenimiento['estado'] === 'en_proceso') {
                $this->consolaModel->actualizarEstado($mantenimiento['id_consola'], 'disponible');
            }
            $this->redirectWithSuccess('Mantenimiento eliminado correctamente');
        }
        $this->redirectWithError('Error al eliminar el mantenimiento');
    }

    private function displayMantenimientos() {
        $pagina = max(1, (int)($_GET['pagina'] ?? 1));
        $porPagina = 10;

        $data = [
            'mantenimientos' => $this->mantenimientoModel->listar($pagina, $porPagina),
            'totalPaginas' => ceil($this->mantenimientoModel->contar() / $porPagina),
            'consolas' => $this->consolaModel->listar(),
            'pagina' => $pagina,
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null
        ];

        extract($data);
       // include_once '../views/mantenimiento.php';
    }

    private function validateFields($fields) {
        foreach ($fields as $field) {
            if (empty($_POST[$field])) {
                $this->redirectWithError("El campo $field es requerido");
            }
        }
    }

    private function redirectWithError($message) {
        header("Location: mantenimiento.php?error=" . urlencode($message));
        exit;
    }

    private function redirectWithSuccess($message) {
        header("Location: mantenimiento.php?success=" . urlencode($message));
        exit;
    }
}


(new MantenimientoController())->handleRequest();
?>