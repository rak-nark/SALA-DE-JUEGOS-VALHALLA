<?php
include('../model/clienteModelo.php');
$obj = new cliente();

if ($_POST) {
    // Validar y sanitizar datos antes de procesar
    $nombre = trim($_POST['nombreCliente'] ?? '');
    $apellido = trim($_POST['apellidoCliente'] ?? '');
    $correo = filter_var(trim($_POST['correoCliente'] ?? ''), FILTER_SANITIZE_EMAIL);
    $contrasena = $_POST['contrasenaCliente'] ?? '';

    if (isset($_POST['guarda'])) {
        $obj->nombreCliente = $nombre;
        $obj->apellidoCliente = $apellido;
        $obj->correoCliente = $correo;
        $obj->contrasenaCliente = $contrasena;
        $obj->agregar();
    }

    if (isset($_POST['modificar'])) {
        $obj->idCliente = (int)($_POST['idCliente'] ?? 0);
        $obj->nombreCliente = $nombre;
        $obj->apellidoCliente = $apellido;
        $obj->correoCliente = $correo;
        $obj->contrasenaCliente = $contrasena;
        $obj->rol = $_POST['rol'] ?? 'usuario'; // Asegurar que el rol tenga un valor
        $obj->modificar();
    }
    if (isset($_POST['elimina'])) {
        $obj->idCliente = (int)$_POST['idCliente'];
        if ($obj->eliminar()) {
            header("Location: home.php?eliminado=1");
            exit();
        } else {
            header("Location: home.php?error=1");
            exit();
        }
    }
}

$cone = new Conexion();
$c = $cone->conectando();
$sql1 = "SELECT COUNT(*) AS totalRegistro FROM cliente";
$ejecuta1 = mysqli_query($c, $sql1);
$res1 = mysqli_fetch_array($ejecuta1);
$totalRegistros = $res1['totalRegistro'];
$maximoRegistros = 15;

$pagina = $_GET['pagina'] ?? 1;
$desde = ($pagina - 1) * $maximoRegistros;
$totalPaginas = ceil($totalRegistros / $maximoRegistros);

$busqueda = $_POST['nombreCliente'] ?? '';
$parametrosBusqueda = '';

if (isset($_POST['buscar']) && !empty($busqueda)) {
    $sql2 = "SELECT * FROM cliente WHERE nombreCliente LIKE ? LIMIT ?, ?";
    $stmt = $c->prepare($sql2);
    $busquedaParam = "%$busqueda%";
    $stmt->bind_param("sii", $busquedaParam, $desde, $maximoRegistros);
    $parametrosBusqueda = "&buscar=$busqueda";
} else {
    $sql2 = "SELECT * FROM cliente LIMIT ?, ?";
    $stmt = $c->prepare($sql2);
    $stmt->bind_param("ii", $desde, $maximoRegistros);
}

$stmt->execute();
$ejecuta = $stmt->get_result();
$res = $ejecuta->fetch_all(MYSQLI_ASSOC);
?>