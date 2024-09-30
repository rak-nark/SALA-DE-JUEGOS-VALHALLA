<?php
include('../model/prestamoModelo.php');
$obj = new prestamo();
if ($_POST) {
    // Aquí podrías agregar alguna lógica si es necesario
}
if (isset($_POST['guarda'])) {
    $obj->fecha = $_POST['fecha'];
    $obj->hora = $_POST['hora'];
    $obj->tiempodeuso = $_POST['tiempodeuso'];
    $obj->reserva = $_POST['reserva'];
    $obj->agregar();
}
if (isset($_POST['modificar'])) {
    $obj->idPrestamo = $_POST['idPrestamo'];
    $obj->fecha = $_POST['fecha'];
    $obj->hora = $_POST['hora'];
    $obj->tiempodeuso = $_POST['tiempodeuso'];
    $obj->reserva = $_POST['reserva'];
    $obj->modificar();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar'])) {
        $c = new Conexion();
        $cone = $c->conectando();
        // Validar y sanitizar los prestamo de entrada
        $idPrestamo = mysqli_real_escape_string($cone, $_POST['idPrestamo']);
        $fecha = mysqli_real_escape_string($cone, $_POST['fecha']);
        $hora = mysqli_real_escape_string($cone, $_POST['hora']);
        $tiempodeuso = mysqli_real_escape_string($cone, $_POST['tiempodeuso']); // <-- Corregido aquí
        $reserva = mysqli_real_escape_string($cone, $_POST['reserva']);
        // Crear y ejecutar la consulta de actualización
        $sql = "UPDATE prestamo SET
                    fecha = '$fecha',
                    hora = '$hora',
                    tiempodeuso = '$tiempodeuso',
                    reserva = '$reserva'
                WHERE idPrestamo = '$idPrestamo'";
                
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
    $obj->idPrestamo = $_POST['idPrestamo'];
    $obj->eliminar();
}
$cone = new Conexion();
$c = $cone->conectando();
$sql1 = "SELECT COUNT(*) AS totalRegistro FROM prestamo";
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
    $obj->fecha = $_POST['fecha'];
    $sql2 = "SELECT * FROM prestamo WHERE fecha LIKE '%$obj->fecha%' LIMIT $desde, $maximoRegistros";
    $ejecuta = mysqli_query($c, $sql2);
    $res = mysqli_fetch_array($ejecuta);
} else {
    $sql2 = "SELECT * FROM prestamo LIMIT $desde, $maximoRegistros";
    $ejecuta = mysqli_query($c, $sql2);
    $res = mysqli_fetch_array($ejecuta);
}
if (isset($_POST['listar'])) {
    // Aquí podrías agregar la lógica si es necesario
}
?>