<?php 
include_once("../connection/conexion.php");
include_once("../controller/mantenimientoControlador.php");

$activePage = 'mantenimiento';
include 'header.php';

$c = new conexion();
$cone = $c->conectando();

// Funciones helper
if (!function_exists('getBadgeClass')) {
    function getBadgeClass($estado) {
        $classes = [
            'pendiente' => 'bg-secondary',
            'en_proceso' => 'bg-primary',
            'completado' => 'bg-success',
            'cancelado' => 'bg-danger',
            'vencido' => 'bg-warning text-dark'
        ];
        return $classes[$estado] ?? 'bg-secondary';
    }
}

if (!function_exists('getEstadoTexto')) {
    function getEstadoTexto($estado, $fechaProgramada = null) {
        $textos = [
            'pendiente' => 'Pendiente',
            'en_proceso' => 'En Proceso',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado'
        ];
        
        if ($estado === 'pendiente' && $fechaProgramada) {
            $hoy = new DateTime();
            $fecha = new DateTime($fechaProgramada);
            if ($fecha < $hoy) {
                return 'Vencido';
            }
        }
        
        return $textos[$estado] ?? 'Desconocido';
    }
}

// Obtener consolas
$sql_consolas = "SELECT id, tipo FROM consola";
$result_consolas = mysqli_query($cone, $sql_consolas);
$consolas = [];
while ($row = mysqli_fetch_assoc($result_consolas)) {
    $consolas[] = $row;
}

// Paginación y búsqueda
$registros_por_pagina = 10;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $registros_por_pagina;
$search = isset($_GET['search']) ? mysqli_real_escape_string($cone, $_GET['search']) : '';

$sql_total = "SELECT COUNT(*) as total FROM mantenimiento" . ($search ? " WHERE descripcion LIKE '%$search%'" : "");
$result_total = mysqli_query($cone, $sql_total);
$total_registros = mysqli_fetch_assoc($result_total)['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Obtener mantenimientos
$sql_mantenimientos = "SELECT * FROM mantenimiento" . ($search ? " WHERE descripcion LIKE '%$search%'" : "") . " ORDER BY fecha_programada DESC LIMIT $inicio, $registros_por_pagina";
$result_mantenimientos = mysqli_query($cone, $sql_mantenimientos);
$mantenimientos = [];
while ($row = mysqli_fetch_assoc($result_mantenimientos)) {
    $mantenimientos[] = $row;
}

// Manejo de acciones (agregar, actualizar, cambiar estado)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'agregar') {
        $tipo = $_POST['tipo'];
        $id_consola = (int)$_POST['id_consola'];
        $descripcion = $_POST['descripcion'];
        $fecha_programada = $_POST['fecha_programada'];
        // CONSULTA PREPARADA para evitar inyección SQL
        $sql = "INSERT INTO mantenimiento (tipo, id_consola, descripcion, fecha_programada, estado, created_at) 
                VALUES (?, ?, ?, ?, 'pendiente', NOW())";
        $stmt = mysqli_prepare($cone, $sql);
        mysqli_stmt_bind_param($stmt, "siss", $tipo, $id_consola, $descripcion, $fecha_programada);
        if (mysqli_stmt_execute($stmt)) {
            $success = "Mantenimiento agregado exitosamente.";
        } else {
            $error = "Error al agregar mantenimiento: " . mysqli_error($cone);
        }
        mysqli_stmt_close($stmt);
    } elseif ($action === 'actualizar') {
        $id = (int)$_POST['id'];
        $tipo = $_POST['tipo'];
        $id_consola = (int)$_POST['id_consola'];
        $descripcion = $_POST['descripcion'];
        $fecha_programada = $_POST['fecha_programada'];
        // CONSULTA PREPARADA para evitar inyección SQL
        $sql = "UPDATE mantenimiento SET tipo=?, id_consola=?, descripcion=?, fecha_programada=? WHERE id=?";
        $stmt = mysqli_prepare($cone, $sql);
        mysqli_stmt_bind_param($stmt, "sissi", $tipo, $id_consola, $descripcion, $fecha_programada, $id);
        if (mysqli_stmt_execute($stmt)) {
            $success = "Mantenimiento actualizado exitosamente.";
        } else {
            $error = "Error al actualizar mantenimiento: " . mysqli_error($cone);
        }
        mysqli_stmt_close($stmt);
    } elseif ($action === 'cambiar_estado') {
        $id = (int)$_POST['id'];
        $estado = $_POST['estado'];
        $update = "";
        $params = [];
        $types = "";
        if ($estado === 'iniciar') {
            $update = "estado=?, fecha_inicio=NOW()";
            $params = ['en_proceso', $id];
            $types = "si";
        } elseif ($estado === 'completar') {
            $update = "estado=?, fecha_fin=NOW()";
            $params = ['completado', $id];
            $types = "si";
        } elseif ($estado === 'cancelar') {
            $update = "estado=?";
            $params = ['cancelado', $id];
            $types = "si";
        }
        if ($update) {
            $sql = "UPDATE mantenimiento SET $update WHERE id=?";
            $stmt = mysqli_prepare($cone, $sql);
            if (strpos($update, 'NOW()') !== false) {
                // Si hay NOW(), solo el primer valor es bindable, el resto es función SQL.
                mysqli_stmt_bind_param($stmt, "si", $params[0], $params[1]);
            } else {
                mysqli_stmt_bind_param($stmt, "si", $params[0], $params[1]);
            }
            if (mysqli_stmt_execute($stmt)) {
                $success = "Estado cambiado exitosamente.";
            } else {
                $error = "Error al cambiar estado: " . mysqli_error($cone);
            }
            mysqli_stmt_close($stmt);
        }
    }
    // Refrescar datos después de una acción
    $result_mantenimientos = mysqli_query($cone, $sql_mantenimientos);
    $mantenimientos = [];
    while ($row = mysqli_fetch_assoc($result_mantenimientos)) {
        $mantenimientos[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Mantenimientos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../configs/css/mantenimiento.css">
</head>
<body>
        <div class="d-flex">
            <!-- Content -->
            <main class="container-fluid p-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="../configs/image/Imagen2-removebg-preview (1).png" alt="Logo" class="img-fluid" style="max-width: 100px;">
                            <h4 class="ms-3 mb-0">Gestión de Mantenimientos</h4>
                        </div>
                        <form method="get" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Buscar..." value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-outline-light"><i class="fas fa-search"></i></button>
                        </form>
                    </div>

                    <div class="card-body">
                        <!-- Notificaciones -->
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                        <?php endif; ?>

                        <!-- Botón Nuevo Mantenimiento -->
                        <div class="mb-4">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoMantenimientoModal">
                                <i class="fas fa-plus-circle me-2"></i>Nuevo Mantenimiento
                            </button>
                        </div>

                        <!-- Tabla de Mantenimientos -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Consola</th>
                                        <th>Descripción</th>
                                        <th>Fecha Programada</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($mantenimientos)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No hay mantenimientos registrados</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($mantenimientos as $m): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($m['id']); ?></td>
                                                <td><?php echo ucfirst(htmlspecialchars($m['tipo'])); ?></td>
                                                <td>
                                                    <?php 
                                                    $consola_nombre = 'Desconocido';
                                                    foreach ($consolas as $consola) {
                                                        if ($consola['id'] == $m['id_consola']) {
                                                            $consola_nombre = $consola['tipo'];
                                                            break;
                                                        }
                                                    }
                                                    echo "ID: " . $m['id_consola'] . " - " . htmlspecialchars($consola_nombre);
                                                    ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($m['descripcion']); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($m['fecha_programada'])); ?></td>
                                                <td>
                                                    <span class="badge <?php echo getBadgeClass(getEstadoTexto($m['estado'], $m['fecha_programada']) === 'Vencido' ? 'vencido' : $m['estado']); ?>">
                                                        <?php echo getEstadoTexto($m['estado'], $m['fecha_programada']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <?php if ($m['estado'] === 'pendiente'): ?>
                                                            <form method="post" class="d-inline">
                                                                <input type="hidden" name="action" value="cambiar_estado">
                                                                <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                                                                <input type="hidden" name="estado" value="iniciar">
                                                                <button type="submit" class="btn btn-sm btn-primary" title="Iniciar">
                                                                    <i class="fas fa-play"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                        <?php if ($m['estado'] === 'en_proceso'): ?>
                                                            <form method="post" class="d-inline">
                                                                <input type="hidden" name="action" value="cambiar_estado">
                                                                <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                                                                <input type="hidden" name="estado" value="completar">
                                                                <button type="submit" class="btn btn-sm btn-success" title="Completar">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                        <?php if (in_array($m['estado'], ['pendiente', 'en_proceso'])): ?>
                                                            <form method="post" class="d-inline">
                                                                <input type="hidden" name="action" value="cambiar_estado">
                                                                <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                                                                <input type="hidden" name="estado" value="cancelar">
                                                                <button type="submit" class="btn btn-sm btn-danger" title="Cancelar">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                        <button class="btn btn-sm btn-warning" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editarMantenimientoModal"
                                                                data-id="<?php echo $m['id']; ?>"
                                                                data-tipo="<?php echo $m['tipo']; ?>"
                                                                data-id_consola="<?php echo $m['id_consola']; ?>"
                                                                data-descripcion="<?php echo htmlspecialchars($m['descripcion']); ?>"
                                                                data-fecha_programada="<?php echo $m['fecha_programada']; ?>"
                                                                title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#detallesMantenimientoModal"
                                                            data-id="<?= $m['id'] ?>"
                                                            data-tipo="<?= $m['tipo'] ?>"
                                                            data-id_consola="<?= $m['id_consola'] ?>"
                                                            data-descripcion="<?= htmlspecialchars($m['descripcion']) ?>"
                                                            data-estado="<?= $m['estado'] ?>"
                                                            data-fecha_programada="<?= date('d/m/Y', strtotime($m['fecha_programada'])) ?>"
                                                            data-created_at="<?= date('d/m/Y H:i', strtotime($m['created_at'])) ?>"
                                                            data-fecha_inicio="<?= $m['fecha_inicio'] ? date('d/m/Y H:i', strtotime($m['fecha_inicio'])) : 'N/A' ?>"
                                                            data-fecha_fin="<?= $m['fecha_fin'] ? date('d/m/Y H:i', strtotime($m['fecha_fin'])) : 'N/A' ?>"
                                                            title="Detalles">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <?php if ($total_paginas > 1): ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item <?php echo $pagina <= 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>&search=<?php echo urlencode($search); ?>">Anterior</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                        <li class="page-item <?php echo $i == $pagina ? 'active' : ''; ?>">
                                            <a class="page-link" href="?pagina=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php echo $pagina >= $total_paginas ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>&search=<?php echo urlencode($search); ?>">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Nuevo Mantenimiento -->
    <div class="modal fade" id="nuevoMantenimientoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Nuevo Mantenimiento</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="agregar">
                        <div class="mb-3">
                            <label class="form-label">Tipo de Mantenimiento</label>
                            <select class="form-select" name="tipo" required>
                                <option value="correctivo">Correctivo</option>
                                <option value="preventivo">Preventivo</option>
                                <option value="limpieza">Limpieza</option>
                                <option value="actualizacion">Actualización</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Consola</label>
                            <select class="form-select" name="id_consola" required>
                                <?php foreach ($consolas as $consola): ?>
                                    <option value="<?= $consola['id'] ?>">ID: <?= $consola['id'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha Programada</label>
                            <input type="date" class="form-control" name="fecha_programada" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Mantenimiento -->
    <div class="modal fade" id="editarMantenimientoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Mantenimiento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="actualizar">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label">Tipo de Mantenimiento</label>
                            <select class="form-select" name="tipo" id="edit_tipo" required>
                                <option value="correctivo">Correctivo</option>
                                <option value="preventivo">Preventivo</option>
                                <option value="limpieza">Limpieza</option>
                                <option value="actualizacion">Actualización</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Consola</label>
                            <select class="form-select" name="id_consola" id="edit_id_consola" required>
                                <?php foreach ($consolas as $consola): ?>
                                    <option value="<?php echo $consola['id']; ?>"><?php echo htmlspecialchars($consola['tipo']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="edit_descripcion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha Programada</label>
                            <input type="date" class="form-control" name="fecha_programada" id="edit_fecha_programada" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <!-- Modal Detalles -->
     <div class="modal fade" id="detallesMantenimientoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detalles</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row">
                        <dt class="col-sm-3">ID:</dt>
                        <dd class="col-sm-9" id="detalle_id"></dd>
                        
                        <dt class="col-sm-3">Tipo:</dt>
                        <dd class="col-sm-9" id="detalle_tipo"></dd>
                        
                        <dt class="col-sm-3">Consola:</dt>
                        <dd class="col-sm-9" id="detalle_consola"></dd>
                        
                        <dt class="col-sm-3">Estado:</dt>
                        <dd class="col-sm-9" id="detalle_estado"></dd>
                        
                        <dt class="col-sm-3">Descripción:</dt>
                        <dd class="col-sm-9" id="detalle_descripcion"></dd>
                        
                        <dt class="col-sm-3">Fecha Programada:</dt>
                        <dd class="col-sm-9" id="detalle_fecha_programada"></dd>
                        
                        <dt class="col-sm-3">Fecha Creación:</dt>
                        <dd class="col-sm-9" id="detalle_created_at"></dd>
                        
                        <dt class="col-sm-3">Fecha Inicio:</dt>
                        <dd class="col-sm-9" id="detalle_fecha_inicio"></dd>
                        
                        <dt class="col-sm-3">Fecha Fin:</dt>
                        <dd class="col-sm-9" id="detalle_fecha_fin"></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../configs/js/mantenimiento.js"></script>
    <script>
        // Manejo del modal de edición
        document.getElementById('editarMantenimientoModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            document.getElementById('edit_id').value = button.getAttribute('data-id');
            document.getElementById('edit_tipo').value = button.getAttribute('data-tipo');
            document.getElementById('edit_id_consola').value = button.getAttribute('data-id_consola');
            document.getElementById('edit_descripcion').value = button.getAttribute('data-descripcion');
            document.getElementById('edit_fecha_programada').value = button.getAttribute('data-fecha_programada');
        });

        // Manejo del modal de detalles
        document.getElementById('detallesMantenimientoModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            document.getElementById('detalle_id').textContent = button.getAttribute('data-id');
            document.getElementById('detalle_tipo').textContent = button.getAttribute('data-tipo');
            document.getElementById('detalle_consola').textContent = 'ID: ' + button.getAttribute('data-id_consola');
            document.getElementById('detalle_estado').textContent = button.getAttribute('data-estado');
            document.getElementById('detalle_descripcion').textContent = button.getAttribute('data-descripcion');
            document.getElementById('detalle_fecha_programada').textContent = button.getAttribute('data-fecha_programada');
            document.getElementById('detalle_created_at').textContent = button.getAttribute('data-created_at');
            document.getElementById('detalle_fecha_inicio').textContent = button.getAttribute('data-fecha_inicio');
            document.getElementById('detalle_fecha_fin').textContent = button.getAttribute('data-fecha_fin');
        });
        
    </script>
</body>
</html>