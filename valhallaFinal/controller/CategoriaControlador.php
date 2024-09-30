<?php
include('../model/categoriaModelo.php');
$obj = new cliente();
if ($_POST) {
    // Aquí podrías agregar alguna lógica si es necesario
}
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar'])) {
        $c = new Conexion();
        $cone = $c->conectando();
        // Validar y sanitizar los cliente de entrada
        $idCliente = mysqli_real_escape_string($cone, $_POST['idCliente']);
        $nombreCliente = mysqli_real_escape_string($cone, $_POST['nombreCliente']);
        $apellidoCliente = mysqli_real_escape_string($cone, $_POST['apellidoCliente']);
        $correoCliente = mysqli_real_escape_string($cone, $_POST['correoCliente']); // <-- Corregido aquí
        $contrasenaCliente = mysqli_real_escape_string($cone, $_POST['contrasenaCliente']);
        // Crear y ejecutar la consulta de actualización
        $sql = "UPDATE cliente SET
                    nombreCliente = '$nombreCliente',
                    apellidoCliente = '$apellidoCliente',
                    correoCliente = '$correoCliente' ,
                    contrasenaCliente = '$contrasenaCliente'
                WHERE idCliente = '$idCliente'";
                
        if (mysqli_query($cone, $sql)) {
            // Mostrar mensaje de éxito
            echo '<script>
                    Swal.fire({
                        position: "top",
                        icon: "success",
                        title: "El Registro Fue Actualizado y los IDs Reasignados",
                        showConfirmButton: false,
                        timer: 3000
                    });
                </script>';
        } else {
            // Mostrar mensaje de error en caso de fallo
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error al actualizar el registro",
                        showConfirmButton: true
                    });
                </script>';
        }
    }
}
if (isset($_POST['elimina'])) {
    $obj->idCliente = $_POST['idCliente'];
    $obj->eliminar();
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
    $sql2 = "SELECT * FROM cliente WHERE nombreCliente LIKE '%$obj->nombreCliente%' LIMIT $desde, $maximoRegistros";
    $ejecuta = mysqli_query($c, $sql2);
    $res = mysqli_fetch_array($ejecuta);
} else {
    $sql2 = "SELECT * FROM cliente LIMIT $desde, $maximoRegistros";
    $ejecuta = mysqli_query($c, $sql2);
    $res = mysqli_fetch_array($ejecuta);
}
if (isset($_POST['listar'])) {
    // Aquí podrías agregar la lógica si es necesario
}
?>
