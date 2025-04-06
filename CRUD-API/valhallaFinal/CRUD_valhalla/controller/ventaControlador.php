<?php
include('../model/ventaModelo.php');
$obj = new venta();
if($_POST){
}
if(isset($_POST['guarda'])){
    $obj->fecha = $_POST['fecha'];
    $obj->monto = $_POST['monto'];
    $obj->id_prestamo = $_POST['id_prestamo'];
    $obj->agregar();
}
if(isset($_POST['modificar'])){
    $obj->id = $_POST['id'];
    $obj->fecha = $_POST['fecha'];
    $obj->monto = $_POST['monto'];
    $obj->id_prestamo = $_POST['id_prestamo'];
    $obj->modificar();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar'])) {
        // Asegúrate de tener una forma de instanciar tu clase o tu función
        $c = new Conexion();
        $cone = $c->conectando();
        // Validar y sanitizar los venta de entrada
        $id = mysqli_real_escape_string($cone, $_POST['id']);
        $fecha = mysqli_real_escape_string($cone, $_POST['fecha']);
        $monto = mysqli_real_escape_string($cone, $_POST['monto']);
        $id_prestamo = mysqli_real_escape_string($cone, $_POST['id_prestamo']);
        // Crear y ejecutar la consulta de actualización
        $sql = "UPDATE venta SET
                    fecha = '$fecha',
                    monto = '$monto',
                    id_prestamo = '$id_prestamo'
                WHERE id = '$id'";
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
if(isset($_POST['elimina'])){
    $obj->id = $_POST['id'];
    $obj->eliminar();
}
$cone = new Conexion();
$c=$cone->conectando();
$sql1="select count(*) as totalRegistro from venta";
$ejecuta1=mysqli_query($c,$sql1);
$res1 = mysqli_fetch_array($ejecuta1);
$totalRegistros = $res1['totalRegistro'];
$maximoRegistros = 5;
if(empty($_GET['pagina'])){
    $pagina=1;
}else{
    $pagina=$_GET['pagina'];
}
$desde = ($pagina-1)*$maximoRegistros;
$totalPaginas=ceil($totalRegistros/$maximoRegistros);
if(isset($_POST['buscar'])){
    
$obj->fecha = $_POST['fecha'];
$sql2="select * from venta where fecha LIKE '%$obj->fecha%' limit $desde,$maximoRegistros ";
$ejecuta=mysqli_query($c,$sql2);
$res = mysqli_fetch_array($ejecuta);
}else{
        $sql2="select * from venta limit $desde,$maximoRegistros ";
        $ejecuta=mysqli_query($c,$sql2);
        $res = mysqli_fetch_array($ejecuta);
}
if(isset($_POST['listar'])){
}
?>