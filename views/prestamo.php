<?php 
include("../connection/conexion.php");
include("../controller/prestamoControlador.php"); 

//nav 
$activePage = 'prestamo';
include 'header.php';


$c = new conexion();
$cone = $c->conectando();
$obj = new Prestamo(); // Asumiendo que existe la clase Prestamo

// Obtener el siguiente ID de préstamo
$sql = "SELECT MAX(idPrestamo) FROM prestamo";
$rs1 = mysqli_query($cone, $sql);
$arreglo = mysqli_fetch_row($rs1);
$suma = ($arreglo[0] > 0) ? $arreglo[0] + 1 : 1;
$obj->idPrestamo = $suma;

// Consulta directa para listar préstamos
$sql_prestamos = "SELECT p.*, c.nombreCliente as nombreCliente 
                 FROM prestamo p
                 JOIN cliente c ON p.id_cliente = c.idCliente
                 ORDER BY p.idPrestamo DESC";
$ejecuta = mysqli_query($cone, $sql_prestamos);

// Paginación
$registros_por_pagina = 10;
$total_registros = mysqli_num_rows($ejecuta);
$total_paginas = ceil($total_registros / $registros_por_pagina);
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $registros_por_pagina;

// Aplicar límite a la consulta
$sql_prestamos .= " LIMIT $inicio, $registros_por_pagina";
$ejecuta = mysqli_query($cone, $sql_prestamos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../configs/css/prestamo.css">
</head>
<body>
    <div class="d-flex">
            <!-- Content -->
            <main class="container-fluid p-4">
                <div class="card">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="../configs/image/Imagen2-removebg-preview (1).png" alt="Logo" class="img-fluid" style="max-width: 100px;">
                            <h4 class="ms-3 mb-0">Gestión de Préstamos</h4>
                        </div>
                        <form class="d-flex" method="post">
                            <input class="form-control me-2" type="search" name="nombreCliente" id="idCliente" placeholder="Buscar por cliente" aria-label="Search">
                            <button class="btn btn-outline-light" type="submit" name="buscar" id="buscar">Buscar</button>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-center mb-3">
                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-plus me-2"></i>Ingresar Préstamo
                            </button>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#reservasModal">
                                <i class="fas fa-calendar-day me-2"></i>Ver Reservas Diarias
                            </button>
                        </div>

                        <!-- Modal Reservas Diarias -->
                        <div class="modal fade" id="reservasModal" tabindex="-1" aria-labelledby="reservasModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="reservasModalLabel">Reservas del Día</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h4 class="text-center mb-3">Total de reservas hoy:</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th>Hora</th>
                                                        <th>Tiempo de Uso</th>
                                                        <th>Consola</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT p.hora, p.tiempodeuso, c.tipo 
                                                             FROM prestamo p JOIN consola c ON p.id_consola = c.id
                                                             WHERE p.fecha = CURDATE()";
                                                    $result = mysqli_query($cone, $query);
                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<tr>
                                                                    <td>" . date("h:i A", strtotime($row['hora'])) . "</td>
                                                                    <td>{$row['tiempodeuso']} min</td>
                                                                    <td>{$row['tipo']}</td>
                                                                  </tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='3' class='text-center'>No hay reservas para hoy.</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Ingresar Préstamo -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="exampleModalLabel">Ingresar Préstamo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            <input type="hidden" name="idPrestamo" value="<?php echo $obj->idPrestamo ?>">
                                            <div class="mb-3">
                                                <label for="fecha" class="form-label">Fecha</label>
                                                <input type="date" name="fecha" class="form-control" id="fecha" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="hora" class="form-label">Hora</label>
                                                <input type="time" name="hora" class="form-control" id="hora" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tiempodeuso" class="form-label">Tiempo de Uso</label>
                                                <select name="tiempodeuso" class="form-select" id="tiempodeuso" required>
                                                    <option value="">Seleccione...</option>
                                                    <option value="30">30 minutos</option>
                                                    <option value="60">1 hora</option>
                                                    <option value="90">1 hora y 30 minutos</option>
                                                    <option value="120">2 horas</option>
                                                    <option value="180">3 horas</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <input type="hidden" name="reserva" value="0">
                                            </div>
                                            <div class="mb-3">
                                                <input type="hidden" name="id_cliente" value="10">
                                            </div>
                                            <div class="mb-3">
                                                <label for="id_consola" class="form-label">ID Consola</label>
                                                <select name="id_consola" class="form-select" id="id_consola" required>
                                                    <option value="">Seleccione una consola...</option>
                                                    <?php
                                                    $consolas = [
                                                        ["id" => 1, "nombre" => "Xbox 360 1"],
                                                        ["id" => 2, "nombre" => "Xbox 360 2"],
                                                        ["id" => 3, "nombre" => "Xbox 360 3"],
                                                        ["id" => 4, "nombre" => "Xbox 360 4"],
                                                        ["id" => 5, "nombre" => "Xbox 360 5"],
                                                        ["id" => 6, "nombre" => "Xbox 360 6"],
                                                        ["id" => 7, "nombre" => "Xbox 360 7"],
                                                        ["id" => 8, "nombre" => "Xbox 360 8"],
                                                        ["id" => 9, "nombre" => "Xbox One 1"],
                                                        ["id" => 10, "nombre" => "Xbox One 2"],
                                                        ["id" => 11, "nombre" => "Xbox One 3"],
                                                        ["id" => 12, "nombre" => "Xbox One 4"],
                                                        ["id" => 13, "nombre" => "Xbox One 5"]
                                                    ];
                                                    foreach ($consolas as $consola) {
                                                        echo "<option value='{$consola['id']}'>{$consola['nombre']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success" name="guarda">Ingresar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla Préstamos -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th>Código</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Tiempo de Uso</th>
                                        <th>Reserva</th>
                                        <th>ID Cliente</th>
                                        <th>ID Consola</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($ejecuta && mysqli_num_rows($ejecuta) > 0) {
                                        while ($res = mysqli_fetch_assoc($ejecuta)) {
                                            $consolas = [
                                                1 => "Xbox 360 1", 2 => "Xbox 360 2", 3 => "Xbox 360 3", 4 => "Xbox 360 4",
                                                5 => "Xbox 360 5", 6 => "Xbox 360 6", 7 => "Xbox 360 7", 8 => "Xbox 360 8",
                                                9 => "Xbox One 1", 10 => "Xbox One 2", 11 => "Xbox One 3", 12 => "Xbox One 4",
                                                13 => "Xbox One 5"
                                            ];
                                            $nombre_consola = $consolas[$res['id_consola']] ?? 'Desconocido';
                                    ?>
                                        <tr>
                                            <td><?php echo $res['idPrestamo']; ?></td>
                                            <td><?php echo $res['fecha']; ?></td>
                                            <td><?php echo date("h:i A", strtotime($res['hora'])); ?></td>
                                            <td><?php echo $res['tiempodeuso']; ?> min</td>
                                            <td><?php echo ($res['reserva'] == 1) ? "Sí" : "No"; ?></td>
                                            <td><?php echo $res['nombreCliente']; ?></td>
                                            <td><?php echo $nombre_consola; ?></td>
                                            <td>
                                                <form action="" method="post" class="d-inline">
                                                    <input type="hidden" name="idPrestamo" value="<?php echo $res['idPrestamo']; ?>">
                                                    <button type="submit" name="elimina" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                                        data-bs-target="#editModal_<?php echo $res['idPrestamo']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Modal Edición -->
                                                <div class="modal fade" id="editModal_<?php echo $res['idPrestamo']; ?>" 
                                                     tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success text-white">
                                                                <h5 class="modal-title">Editar Préstamo</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post">
                                                                    <input type="hidden" name="idPrestamo" value="<?php echo $res['idPrestamo']; ?>">
                                                                    <div class="mb-3">
                                                                        <label for="fecha_<?php echo $res['idPrestamo']; ?>" class="form-label">Fecha</label>
                                                                        <input type="date" name="fecha" class="form-control" id="fecha_<?php echo $res['idPrestamo']; ?>" 
                                                                               value="<?php echo $res['fecha']; ?>" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="hora_<?php echo $res['idPrestamo']; ?>" class="form-label">Hora</label>
                                                                        <input type="time" name="hora" class="form-control" id="hora_<?php echo $res['idPrestamo']; ?>" 
                                                                               value="<?php echo $res['hora']; ?>" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tiempo_<?php echo $res['idPrestamo']; ?>" class="form-label">Tiempo de Uso</label>
                                                                        <select name="tiempodeuso" class="form-select" id="tiempo_<?php echo $res['idPrestamo']; ?>" required>
                                                                            <option value="30" <?php echo ($res['tiempodeuso'] == 30) ? 'selected' : ''; ?>>30 minutos</option>
                                                                            <option value="60" <?php echo ($res['tiempodeuso'] == 60) ? 'selected' : ''; ?>>1 hora</option>
                                                                            <option value="90" <?php echo ($res['tiempodeuso'] == 90) ? 'selected' : ''; ?>>1 hora 30 minutos</option>
                                                                            <option value="120" <?php echo ($res['tiempodeuso'] == 120) ? 'selected' : ''; ?>>2 horas</option>
                                                                            <option value="180" <?php echo ($res['tiempodeuso'] == 180) ? 'selected' : ''; ?>>3 horas</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="reserva_<?php echo $res['idPrestamo']; ?>" class="form-label">Reserva</label>
                                                                        <select name="reserva" class="form-select" id="reserva_<?php echo $res['idPrestamo']; ?>" required>
                                                                            <option value="1" <?php echo ($res['reserva'] == 1) ? 'selected' : ''; ?>>Sí</option>
                                                                            <option value="0" <?php echo ($res['reserva'] == 0) ? 'selected' : ''; ?>>No</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="id_cliente_<?php echo $res['idPrestamo']; ?>" class="form-label">ID Cliente</label>
                                                                        <input type="number" name="id_cliente" class="form-control" id="id_cliente_<?php echo $res['idPrestamo']; ?>" 
                                                                               value="<?php echo $res['id_cliente']; ?>" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="id_consola_<?php echo $res['idPrestamo']; ?>" class="form-label">ID Consola</label>
                                                                        <select name="id_consola" class="form-select" id="id_consola_<?php echo $res['idPrestamo']; ?>" required>
                                                                            <option value="">Seleccione una consola...</option>
                                                                            <?php
                                                                            foreach ($consolas as $id => $nombre) {
                                                                                $selected = ($id == $res['id_consola']) ? 'selected' : '';
                                                                                echo "<option value='$id' $selected>$nombre</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
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
                                        echo "<tr><td colspan='8' class='text-center'>No hay registros</td></tr>";
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
                                        <a class="page-link" href="?pagina=1">Primera</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>">Anterior</a>
                                    </li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                    <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <?php if ($pagina < $total_paginas): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>">Siguiente</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="?pagina=<?php echo $total_paginas; ?>">Última</a>
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
    <script src="../configs/js/prestamo.js"></script>
</body>
</html>