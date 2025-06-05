<?php 
include_once ("../connection/conexion.php");
include_once ("../controller/clienteControlador.php"); 

//nav 
$activePage = 'home';
include_once 'header.php';
?>
<?php 
$c = new conexion();
$cone = $c->conectando();
$sql = "select max(idCliente) from cliente";
$rs1 = mysqli_query($cone, $sql);
$arreglo = mysqli_fetch_row($rs1);
$suma = ($arreglo[0] > 0) ? 1 + $arreglo[0] : 1;
$obj->idCliente = $suma;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../configs/css/home.css">
</head>
<body class="bg-light">  
    <div class="wrapper d-flex">
    
    
    <div class="container-fluid p-4">
    <div class="card border-0 shadow rounded-4">
        <div class="card-body">
            <!-- Encabezado -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                <img src="../configs/image/Imagen2-removebg-preview (1).png" alt="Logo" width="150" class="mb-3 mb-md-0">

                <!-- Buscador -->
                <form class="d-flex" method="post">
                    <div class="input-group shadow-sm">
                        <input class="form-control border-success" type="search" name="nombreCliente" placeholder="Buscar por nombre">
                        <button class="btn btn-success" type="submit" name="buscar">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Botón Nuevo Cliente -->
            <div class="text-end mb-3">
                <button class="btn btn-success shadow" data-bs-toggle="modal" data-bs-target="#nuevoClienteModal">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Cliente
                </button>
            </div>

            <!-- Modal Nuevo Cliente -->
            <div class="modal fade" id="nuevoClienteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content rounded-4">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">Agregar Nuevo Cliente</h5>
                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombreCliente" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Apellido</label>
                                    <input type="text" name="apellidoCliente" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Correo</label>
                                    <input type="email" name="correoCliente" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contraseña</label>
                                    <input type="password" name="contrasenaCliente" class="form-control" required>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" name="guarda" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>Guardar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Clientes -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($res)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hay registros de clientes</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($res as $fila): ?>
                                <tr>
                                    <td><?= htmlspecialchars($fila['idCliente']) ?></td>
                                    <td><?= htmlspecialchars($fila['nombreCliente']) ?></td>
                                    <td><?= htmlspecialchars($fila['apellidoCliente']) ?></td>
                                    <td><?= htmlspecialchars($fila['correoCliente']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $fila['rol'] === 'administrador' ? 'success' : 'secondary' ?>">
                                            <?= ucfirst($fila['rol'] ?? 'usuario') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Editar -->
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal<?= $fila['idCliente'] ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Eliminar -->
                                            <form method="post">
                                                <input type="hidden" name="idCliente" value="<?= $fila['idCliente'] ?>">
                                                <button type="button" onclick="eliminarCliente(this)" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edición -->
                                <div class="modal fade" id="editModal<?= $fila['idCliente'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content rounded-4">
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title">Editar Cliente #<?= $fila['idCliente'] ?></h5>
                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post">
                                                    <input type="hidden" name="idCliente" value="<?= $fila['idCliente'] ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nombre</label>
                                                        <input type="text" name="nombreCliente" class="form-control" value="<?= htmlspecialchars($fila['nombreCliente']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Apellido</label>
                                                        <input type="text" name="apellidoCliente" class="form-control" value="<?= htmlspecialchars($fila['apellidoCliente']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Correo</label>
                                                        <input type="email" name="correoCliente" class="form-control" value="<?= htmlspecialchars($fila['correoCliente']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nueva Contraseña</label>
                                                        <input type="password" name="contrasenaCliente" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Rol</label>
                                                        <select name="rol" class="form-select">
                                                            <option value="usuario" <?= ($fila['rol'] === 'usuario' || empty($fila['rol'])) ? 'selected' : '' ?>>Usuario</option>
                                                            <option value="administrador" <?= $fila['rol'] === 'administrador' ? 'selected' : '' ?>>Administrador</option>
                                                        </select>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" name="modificar" class="btn btn-success">
                                                            <i class="fas fa-save me-2"></i>Guardar Cambios
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if($pagina > 1): ?>
                        <li class="page-item"><a class="page-link text-success" href="?pagina=1">&laquo;&laquo;</a></li>
                        <li class="page-item"><a class="page-link text-success" href="?pagina=<?= $pagina - 1 ?>">&laquo;</a></li>
                    <?php endif; ?>

                    <?php for($i = max(1, $pagina - 2); $i <= min($totalPaginas, $pagina + 2); $i++): ?>
                        <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                            <a class="page-link <?= $i != $pagina ? 'text-success' : '' ?>" href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if($pagina < $totalPaginas): ?>
                        <li class="page-item"><a class="page-link text-success" href="?pagina=<?= $pagina + 1 ?>">&raquo;</a></li>
                        <li class="page-item"><a class="page-link text-success" href="?pagina=<?= $totalPaginas ?>">&raquo;&raquo;</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="../configs/js/home.js"></script>
    
    <script>
        // Función para eliminar cliente con confirmación
        async function eliminarCliente(btn) {
            const form = btn.closest('form');
            const confirmacion = await Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });
            
            if (confirmacion.isConfirmed) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'elimina';
                input.value = '1';
                form.appendChild(input);
                form.submit();
            }
        }

        // Mensaje tras eliminar (si viene de redirección)
        <?php if(isset($_GET['eliminado'])): ?>
            Swal.fire({
                title: '¡Eliminado!',
                text: 'El cliente ha sido eliminado correctamente',
                icon: 'success',
                confirmButtonColor: '#198754'
            });
        <?php endif; ?>
    </script>
</body>
</html>