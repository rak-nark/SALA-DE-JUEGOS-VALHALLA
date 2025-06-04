<?php
require_once('../model/consolaModelo.php');

$obj = new Consola();

// Configuración de paginación
$maximoRegistros = 13;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$pagina = max(1, $pagina);
$desde = ($pagina-1) * $maximoRegistros;

// Obtener conexión
$c = new Conexion();
$cone = $c->conectando();

// Obtener total de registros
$sqlTotal = "SELECT COUNT(*) as total FROM consola";
$ejecutaTotal = mysqli_query($cone, $sqlTotal);
$totalRegistros = mysqli_fetch_assoc($ejecutaTotal)['total'];
$totalPaginas = ceil($totalRegistros / $maximoRegistros);

// Procesar formularios
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['modificar'])) {
        // Validar que el id es numérico
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $estado = isset($_POST['estado']) ? $_POST['estado'] : '';

        // Opcional: validar que el estado sea uno permitido
        $estadosValidos = ['disponible', 'no_disponible', 'mantenimiento'];
        if ($id > 0 && in_array($estado, $estadosValidos)) {
            $obj->id = $id;
            $obj->estado = $estado;
            $obj->modificarEstado(); // Este método debe usar prepared statements en el modelo
        }

        header("Location: consola.php?pagina=$pagina");
        exit();
    }

    if(isset($_POST['buscar']) && !empty($_POST['busqueda'])) {
        $resultados = $obj->buscarPorTipo($_POST['busqueda']);
    }
}

// Obtener datos para mostrar
if(!isset($resultados)) {
    $sql = "SELECT * FROM consola LIMIT $desde, $maximoRegistros";
    $resultados = mysqli_query($cone, $sql);
}
?>