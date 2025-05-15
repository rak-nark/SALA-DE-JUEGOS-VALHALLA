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
        $obj->id = $_POST['id'];
        $obj->estado = $_POST['estado'];
        $obj->modificarEstado();
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