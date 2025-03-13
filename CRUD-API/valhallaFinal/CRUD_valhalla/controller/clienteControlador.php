<?php
include('../model/clienteModelo.php');
$obj = new cliente();

if ($_POST) {
    if (isset($_POST['guarda'])) {
        $obj->nombreCliente = $_POST['nombreCliente'];
        $obj->apellidoCliente = $_POST['apellidoCliente'];
        $obj->correoCliente = $_POST['correoCliente'];
        $obj->contrasenaCliente = $_POST['contrasenaCliente'];
        $obj->agregar();
    }

    if (isset($_POST['modificar'])) {
        $obj->idCliente = $_POST['idCliente'];
        $obj->nombreCliente = $_POST['nombreCliente'];
        $obj->apellidoCliente = $_POST['apellidoCliente'];
        $obj->correoCliente = $_POST['correoCliente'];
        $obj->contrasenaCliente = $_POST['contrasenaCliente'];
        $obj->modificar();
    }

    if (isset($_POST['elimina'])) {
        $obj->idCliente = $_POST['idCliente'];
        $obj->eliminar();
    }
}

$cone = new Conexion();
$c = $cone->conectando();
$sql1 = "SELECT COUNT(*) AS totalRegistro FROM cliente";
$ejecuta1 = mysqli_query($c, $sql1);
$res1 = mysqli_fetch_array($ejecuta1);
$totalRegistros = $res1['totalRegistro'];
$maximoRegistros = 5;

if (empty($_GET['pagina'])) {
    $pagina = 1;
} else {
    $pagina = $_GET['pagina'];
}

$desde = ($pagina - 1) * $maximoRegistros;
$totalPaginas = ceil($totalRegistros / $maximoRegistros);

if (isset($_POST['buscar'])) {
    $obj->nombreCliente = $_POST['nombreCliente'];
    $sql2 = "SELECT * FROM cliente WHERE nombreCliente LIKE ? LIMIT ?, ?";
    $stmt = $c->prepare($sql2);
    $busqueda = "%$obj->nombreCliente%";
    $stmt->bind_param("sii", $busqueda, $desde, $maximoRegistros);
    $stmt->execute();
    $ejecuta = $stmt->get_result();
} else {
    $sql2 = "SELECT * FROM cliente LIMIT ?, ?";
    $stmt = $c->prepare($sql2);
    $stmt->bind_param("ii", $desde, $maximoRegistros);
    $stmt->execute();
    $ejecuta = $stmt->get_result();
}

$res = $ejecuta->fetch_all(MYSQLI_ASSOC);
?>