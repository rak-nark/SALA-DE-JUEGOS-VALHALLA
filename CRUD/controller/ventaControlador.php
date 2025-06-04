<?php
include('../model/ventaModelo.php');
$obj = new venta();
if($_POST){
}
if(isset($_POST['guarda'])){
    if (empty($_POST['id_prestamo'])) {
        die("Error: El campo id_prestamo es obligatorio.");
    }
    $obj->fecha = $_POST['fecha'];
    $obj->monto = $_POST['monto'];
    $obj->id_prestamo = !empty($_POST['id_prestamo']) ? $_POST['id_prestamo'] : null;
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
                    id_prestamo = " . ($id_prestamo !== "NULL" ? "'$id_prestamo'" : "NULL") . " 
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
$maximoRegistros = 10;
if(empty($_GET['pagina'])){
    $pagina=1;
}else{
    $pagina=$_GET['pagina'];
}
$desde = ($pagina-1)*$maximoRegistros;
$totalPaginas=ceil($totalRegistros/$maximoRegistros);
if(isset($_POST['buscar'])){
    $obj->fecha = $_POST['fecha'];
    // Consulta preparada para evitar inyección SQL
    $stmt = mysqli_prepare($c, "SELECT * FROM venta WHERE fecha LIKE ? LIMIT ?, ?");
    $fecha_busqueda = '%' . $obj->fecha . '%';
    mysqli_stmt_bind_param($stmt, 'sii', $fecha_busqueda, $desde, $maximoRegistros);
    mysqli_stmt_execute($stmt);
    $ejecuta = mysqli_stmt_get_result($stmt);
    $res = mysqli_fetch_array($ejecuta);
    mysqli_stmt_close($stmt);
}else{
    $sql2="select * from venta limit $desde,$maximoRegistros ";
    $ejecuta=mysqli_query($c,$sql2);
    $res = mysqli_fetch_array($ejecuta);
}
if(isset($_POST['listar'])){
}
?>

<script>
    public function generarReporte($tipo, $param1 = null, $param2 = null) {
        switch ($tipo) {
            case 'diario':
                $data = $this->ventasModel->obtenerVentasDiarias($param1);
                break;
            case 'mensual':
                $data = $this->ventasModel->obtenerVentasMensuales($param1, $param2);
                break;
            case 'semestral':
                $data = $this->ventasModel->obtenerVentasSemestrales($param1, $param2);
                break;
            case 'anual':
                $data = $this->ventasModel->obtenerVentasAnuales($param1);
                break;
            default:
                die("Tipo de reporte no válido");
        }

        $this->exportarExcel($data, $tipo);
    }

    private function exportarExcel($data, $tipo) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Encabezados
        $encabezados = ["ID Venta", "Fecha", "Monto", "ID Préstamo"];
        $col = 0;
        foreach ($encabezados as $encabezado) {
            $sheet->setCellValueByColumnAndRow($col, 1, $encabezado);
            $col++;
        }

        // Datos
        $fila = 2;
        foreach ($data as $venta) {
            $sheet->setCellValue("A{$fila}", $venta['idVenta']);
            $sheet->setCellValue("B{$fila}", $venta['fecha']);
            $sheet->setCellValue("C{$fila}", $venta['monto']);
            $sheet->setCellValue("D{$fila}", $venta['idPrestamo']);
            $fila++;
        }

        // Guardar archivo
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='reporte_{$tipo}.xls'");
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $writer->save('php://output');
        exit;
    }
</script>