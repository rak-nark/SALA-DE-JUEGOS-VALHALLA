<?php
include('../model/prestamoModelo.php');
$obj = new prestamo();
if ($_POST) {
    // Aquí podrías agregar alguna lógica si es necesario
}
if (isset($_POST['guarda'])) {
    // Validación básica (puedes expandir según tus reglas)
    $obj->fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
    $obj->hora = isset($_POST['hora']) ? $_POST['hora'] : null;
    $obj->tiempodeuso = isset($_POST['tiempodeuso']) ? $_POST['tiempodeuso'] : null;
    $obj->reserva = isset($_POST['reserva']) ? $_POST['reserva'] : null;
    $obj->id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : null;
    $obj->id_consola = isset($_POST['id_consola']) ? $_POST['id_consola'] : null;

    // El método agregar() debe usar consultas preparadas en el modelo
    $obj->agregar();
}
if (isset($_POST['modificar'])) {
    $obj->idPrestamo = $_POST['idPrestamo'];
    $obj->fecha = $_POST['fecha'];
    $obj->hora = $_POST['hora'];
    $obj->tiempodeuso = $_POST['tiempodeuso'];
    $obj->reserva = $_POST['reserva'];
    $obj->id_consola = $_POST['id_consola'];

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
        $id_consola = mysqli_real_escape_string($cone, $_POST['id_consola']);
        // Crear y ejecutar la consulta de actualización
        $sql = "UPDATE prestamo SET
                    fecha = '$fecha',
                    hora = '$hora',
                    tiempodeuso = '$tiempodeuso',
                    reserva = '$reserva',
                    id_consola = '$id_consola'
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
$maximoRegistros = 15;
if (empty($_GET['pagina'])) {
    $pagina = 1;
} else {
    $pagina = $_GET['pagina'];
}
$desde = ($pagina - 1) * $maximoRegistros;
$totalPaginas = ceil($totalRegistros / $maximoRegistros);
if (isset($_POST['buscar'])) {
    $obj->fecha = $_POST['fecha'];
    // Usar consulta preparada para evitar inyección SQL
    $stmt = mysqli_prepare(
        $c,
        "SELECT * FROM prestamo WHERE fecha LIKE ? LIMIT ?, ?"
    );
    // Preparar el parámetro de búsqueda
    $fecha_busqueda = '%' . $obj->fecha . '%';
    // bind_param: s = string, i = integer
    mysqli_stmt_bind_param($stmt, 'sii', $fecha_busqueda, $desde, $maximoRegistros);
    mysqli_stmt_execute($stmt);
    $ejecuta = mysqli_stmt_get_result($stmt);
    $res = mysqli_fetch_array($ejecuta);
    mysqli_stmt_close($stmt);
} else {
    $sql2 = "SELECT * FROM prestamo LIMIT $desde, $maximoRegistros";
    $ejecuta = mysqli_query($c, $sql2);
    $res = mysqli_fetch_array($ejecuta);
}
if (isset($_POST['listar'])) {
    // Aquí podrías agregar la lógica si es necesario
}
?>