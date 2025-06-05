<?php 
include_once("../connection/conexion.php");
include_once("../controller/ventaControlador.php");

//nav 
$activePage = 'venta';
include_once 'header.php';

$c = new conexion();
$cone = $c->conectando();
$obj = new Venta(); // Asumiendo que ventaControlador.php tiene una clase Venta

// Obtener el siguiente ID de venta
$sql = "SELECT MAX(id) AS max_id FROM venta";
$rs1 = mysqli_query($cone, $sql);
$arreglo = mysqli_fetch_assoc($rs1);
$suma = ($arreglo && $arreglo['max_id'] > 0) ? $arreglo['max_id'] + 1 : 1;
$obj->id = $suma;

// Consulta directa para listar ventas
$sql_ventas = "SELECT * FROM venta ORDER BY id DESC"; // Ajusta según tu necesidad
$ejecuta = mysqli_query($cone, $sql_ventas);

// Paginación básica (ajusta según tus necesidades)
$registros_por_pagina = 10; // Define cuántos registros por página
$total_registros = mysqli_num_rows($ejecuta);
$total_paginas = ceil($total_registros / $registros_por_pagina);
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $registros_por_pagina;

// Aplicar límite a la consulta
$sql_ventas .= " LIMIT $inicio, $registros_por_pagina";
$ejecuta = mysqli_query($cone, $sql_ventas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="../configs/css/venta.css">
</head>
<body>
    <div class="d-flex">
            <!-- Content -->
            <main class="container-fluid p-4">
                <div class="card">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="../configs/image/Imagen2-removebg-preview (1).png" alt="Logo" class="img-fluid" style="max-width: 100px;">
                            <h4 class="ms-3 mb-0">Gestión de Ventas</h4>
                        </div>
                        <form class="d-flex" method="post">
                            <input class="form-control me-2" type="search" name="nombreCliente" placeholder="Buscar por cliente" aria-label="Search">
                            <button class="btn btn-outline-light" type="submit" name="buscar">Buscar</button>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-center mb-3">
                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-plus me-2"></i>Ingresar Venta
                            </button>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalGanancias">
                                <i class="fas fa-chart-line me-2"></i>Ganancias Diarias
                            </button>
                        </div>

                        <!-- Modal Ganancias Diarias -->
                        <div class="modal fade" id="modalGanancias" tabindex="-1" aria-labelledby="modalGananciasLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="modalGananciasLabel">Ganancias del Día</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        $sql = "SELECT SUM(monto) AS total FROM venta WHERE fecha = CURDATE()";
                                        $resultado = mysqli_query($cone, $sql);
                                        $fila = mysqli_fetch_assoc($resultado);
                                        $total_ganancias_hoy = $fila['total'] ?? 0;
                                        ?>
                                        <h4>Total de hoy: <strong><?php echo number_format($total_ganancias_hoy, 0); ?> $</strong></h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Ingresar Venta -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="exampleModalLabel">Ingresar Venta</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            <input type="hidden" name="id" value="<?php echo $obj->id ?>">
                                            <div class="mb-3">
                                                <label for="fecha" class="form-label">Fecha</label>
                                                <input type="date" name="fecha" class="form-control" id="fecha" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="monto" class="form-label">Monto</label>
                                                <input type="number" step="0.01" name="monto" class="form-control" id="monto" required>
                                            </div>
                                            <button type="submit" class="btn btn-success" name="guarda">Ingresar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla Ventas -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th>Código</th>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($ejecuta && mysqli_num_rows($ejecuta) > 0) {
                                        while ($res = mysqli_fetch_array($ejecuta)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $res['id']; ?></td>
                                            <td><?php echo $res['fecha']; ?></td>
                                            <td><?php echo number_format($res['monto'], 0); ?> $</td>
                                            <td>
                                                <form action="" method="post" class="d-inline">
                                                    <input type="hidden" name="id" value="<?php echo $res['id']; ?>">
                                                    <button type="submit" name="elimina" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                                        data-bs-target="#editModal_<?php echo $res['id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Modal Edición -->
                                                <div class="modal fade" id="editModal_<?php echo $res['id']; ?>" 
                                                     tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success text-white">
                                                                <h5 class="modal-title">Editar Venta</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $res['id']; ?>">
                                                                    <div class="mb-3">
                                                                        <label for="fecha_<?php echo $res['id']; ?>" class="form-label">Fecha</label>
                                                                        <input type="date" name="fecha" class="form-control" id="fecha_<?php echo $res['id']; ?>" 
                                                                               value="<?php echo $res['fecha']; ?>" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="monto_<?php echo $res['id']; ?>" class="form-label">Monto</label>
                                                                        <input type="number" name="monto" class="form-control" id="monto_<?php echo $res['id']; ?>" 
                                                                            value="<?php echo intval($res['monto']); ?>" min="0" step="1" required>
                                                                    </div>
                                                                    <button type="submit" name="modificar" class="btn btn-success">Actualizar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>No hay registros</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                <?php if ($pagina > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?pagina=1">«</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>">‹</a>
                                    </li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                    <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <?php if ($pagina < $totalPaginas): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>">›</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="?pagina=<?php echo $totalPaginas; ?>">»</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../configs/js/venta.js"></script>
</body>
</html>