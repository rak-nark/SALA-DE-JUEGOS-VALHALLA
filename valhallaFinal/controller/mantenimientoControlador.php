<?php
include('../model/mantenimientoModelo.php');
$obj = new mantenimiento();
if($_POST){
}
if(isset($_POST['guarda'])){
    $obj->tipo = $_POST['tipo'];
    $obj->descripcion = $_POST['descripcion'];
    $obj->id_consola = $_POST['id_consola'];
    $obj->fecha = $_POST['fecha'];
    $obj->agregar();
}
if(isset($_POST['modificar'])){
    $obj->id = $_POST['id'];
    $obj->tipo = $_POST['tipo'];
    $obj->descripcion = $_POST['descripcion'];
    $obj->modificar();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar'])) {
        // Asegúrate de tener una forma de instanciar tu clase o tu función
        $c = new Conexion();
        $cone = $c->conectando();
        // Validar y sanitizar los mantenimiento de entrada
        $id = mysqli_real_escape_string($cone, $_POST['id']);
        $tipo = mysqli_real_escape_string($cone, $_POST['tipo']);
        $descripcion = mysqli_real_escape_string($cone, $_POST['descripcion']);
        $id_consola = mysqli_real_escape_string($cone, $_POST['id_consola']);
        $fecha = mysqli_real_escape_string($cone, $_POST['fecha']);
        // Crear y ejecutar la consulta de actualización
        $sql = "UPDATE mantenimiento SET
                    tipo = '$tipo',
                    descripcion = '$descripcion'
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
$sql1="select count(*) as totalRegistro from mantenimiento";
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
    
$obj->tipo = $_POST['tipo'];
$sql2="select * from mantenimiento where tipo LIKE '%$obj->tipo%' limit $desde,$maximoRegistros ";
$ejecuta=mysqli_query($c,$sql2);
$res = mysqli_fetch_array($ejecuta);
}else{
        $sql2="select * from mantenimiento limit $desde,$maximoRegistros ";
        $ejecuta=mysqli_query($c,$sql2);
        $res = mysqli_fetch_array($ejecuta);
}
if(isset($_POST['listar'])){
}
?>