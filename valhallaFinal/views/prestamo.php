<?php 
include ("../connection/conexion.php");
include ("../controller/prestamoControlador.php"); 
$c = new conexion();
$cone = $c->conectando();
$sql = "SELECT MAX(idPrestamo) FROM prestamo";
$rs1 = mysqli_query($cone, $sql);
$arreglo = mysqli_fetch_row($rs1);
if ($arreglo[0] > 0) {
    $suma = 1 + $arreglo[0];
} else {
    $suma = 1;
}
$obj->idPrestamo = $suma;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="../configs/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f7f9fa;
        }
        .wrapper {
            display: flex;
            height: 100vh;
        }
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #2a7f62;
            color: white;
            transition: all 0.3s;
            height: 100%;
            overflow-y: auto;
        }
        .sidebar.collapsed {
            width: 60px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 15px;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
        }
        .sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .menu-text {
            margin-left: 10px;
            transition: opacity 0.3s;
        }
        .sidebar.collapsed .menu-text {
            display: none;
        }
        /* Main content area */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        /* Navbar superior */
        .navbar {
            background-color: #538083;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-left, .navbar-right {
            display: flex;
            align-items: center;
        }
        .profile {
            margin-right: 1rem;
            cursor: pointer;
        }
        /* Submenu */
        .submenu {
            position: relative;
        }
        .submenu-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: rgba(137, 144, 159, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .submenu:hover .submenu-content {
            display: block;
        }
        .submenu-content a {
            color: white;
            padding: 10px;
            display: block;
            text-decoration: none;
        }
        .submenu-content a:hover {
            background-color: rgba(195, 172, 206, 0.8);
        }
        /* Botón de colapsar */
        #menuToggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            margin-right: 1rem;
        }
        /* Contenido */
        .content {
            padding: 2rem;
            flex-grow: 1;
            overflow-y: auto;
        }
        /* Tablas */
        .table {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .table th {
            background-color: #2a7f62;
            color: white;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        /* Estilos para modales */
        .modal-content {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .modal-header {
            border-bottom: none;
        }
        .modal-title {
            color: #2a7f62;
        }
        .modal-body {
            color: #333;
        }
        /* Estilos para botones */
        .btn-primary {
            background-color: #2a7f62;
            border: none;
        }
        .btn-primary:hover {
            background-color: rgba(42, 127, 98, 0.8);
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: rgba(220, 53, 69, 0.8);
        }
        .btn-warning {
            background-color: #ffc107;
        }
        .btn-warning:hover {
            background-color: rgba(255, 193, 7, 0.8);
        }
        /* Pagination */
        .pagination {
            margin-top: 20px;
            justify-content: flex-end;
        }
        .pagination .page-item.active .page-link {
            background-color: #2a7f62;
            border-color: #2a7f62;
        }
/* Imagen en el logo */
.navbar-brand img {
    pointer-events: none; /* Evita la interacción con la imagen */
}
    </style>
</head>
<body>
<div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <ul>
                <li><a href="iniciosesion.php"title="Gestiòn usuarios"><i class="fa-solid fa-circle-user"></i><span class="menu-text">Gestión Clientes</span></a></li>
                <li><a href="consola.php"title="Consolas"><i class="fa-solid fa-pager"></i><span class="menu-text">Consolas</span></a></li>
                <li><a href="mantenimiento.php"title="Registrar Mantenimiento"><i class="fa-solid fa-book"></i><span class="menu-text">Mantenimiento</span></a></li>
                <li><a href="prestamo.php"title="Prestamos"><i class="fa-solid fa-globe"></i><span class="menu-text">Prestamos</span></a></li>
                <li><a href="venta.php"title="Consultar Ventas"><i class="fa-solid fa-money-bill-wave"></i><span class="menu-text">Total Ventas</span></a></li>
            </ul>
        </div>
        <div class="main-content">
            <!-- Navbar superior -->
            <div class="navbar">
                <div class="navbar-left">
                    <button id="menuToggle"><i class="fas fa-bars"></i></button>
                    <span>Panel de Navegación</span>
                </div>
                <div class="navbar-right">
                    <div class="profile">Perfil <i class="fas fa-user"></i></div>
                    <div class="submenu">
                        <a href="#" class="submenu-toggle">Menú <i class="fas fa-bars"></i></a>
                        <div class="submenu-content">
                            <a href="login.php">Iniciar Sesión</a>
                            <a href="resgitro.php">Registrar</a>
                            <a href="logout.php">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contenido -->
            <div class="content">
                <div class="container-md">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../configs/image/Imagen2-removebg-preview (1).png" alt="Logo" width="150" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" name="fecha" id="idPrestamo" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit" name="buscar" id="buscar">Buscar</button>
                </form>
            </div>
        </div>
        
    </nav>
    <center>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Ingresar Prestamo
        </button>
    </center>
    <!-- Modal de Ingreso -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingrese los prestamos registrados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="mb-3">
                            <input type="hidden" name="idPrestamo" value="<?php echo $obj->idPrestamo ?>" class="form-control" id="exampleInputText1">
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" name="fecha" class="form-control" id="fecha" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora</label>
                            <input type="time" name="hora" class="form-control" id="hora" required>
                        </div>
                        <div class="mb-3">
                            <label for="tiempodeuso" class="form-label">Tiempo de uso</label>
                            <select name="tiempodeuso" class="form-control" id="tiempodeuso" required>
                                <option value="">Seleccione...</option>
                                <option value="30">30 minutos</option>
                                <option value="60">1 hora</option>
                                <option value="90">1 hora y media</option>
                                <option value="120">2 horas</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reserva" class="form-label">Reserva</label>
                            <input type="number" name="reserva" class="form-control" id="reserva" min="0" max="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="guarda" value="guarda">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabla de prestamos -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Tiempo de uso</th>
                    <th scope="col">Reserva</th>
                    <th scope="col">ID_Cliente</th>
                    <th scope="col">ID_consola</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($res == 0) {
                    echo "<tr><td colspan='6'>No hay registros</td></tr>";
                } else {
                    do {
                        ?>
                        <tr>
                            <td><?php echo $res[0] ?></td>
                            <td><?php echo $res[1] ?></td>
                            <td><?php echo $res[2] ?></td>
                            <td><?php echo $res[3] ?></td>
                            <td><?php echo $res[4] ?></td>
                            <td><?php echo $res[5] ?></td>
                            <td><?php echo $res[6] ?></td>
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="idPrestamo" value="<?php echo $res[0]; ?>">
                                    <button type="submit" name="elimina" value="elimina" class="btn btn-danger">Eliminar</button>
                                </form>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="idPrestamo" value="<?php echo $res[0]; ?>">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal_<?php echo $res[0]; ?>">
                                        Editar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal de edición -->
                        <div class="modal fade" id="editModal_<?php echo $res[0]; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Prestamo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            <input type="hidden" name="idPrestamo" value="<?php echo $res[0]; ?>">
                                            <div class="mb-3">
                                                <label for="fecha_<?php echo $res[0]; ?>" class="form-label">Fecha</label>
                                                <input type="date" name="fecha" class="form-control" id="fecha_<?php echo $res[0]; ?>" value="<?php echo $res[1]; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="hora_<?php echo $res[0]; ?>" class="form-label">Hora</label>
                                                <input type="time" name="hora" class="form-control" id="hora_<?php echo $res[0]; ?>" value="<?php echo $res[2]; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tiempodeuso_<?php echo $res[0]; ?>" class="form-label">Tiempo de uso</label>
                                                <select name="tiempodeuso" class="form-control" id="tiempodeuso_<?php echo $res[0]; ?>" required>
                                                    <option value="">Seleccione...</option>
                                                    <option value="30" <?php echo ($res[3] == '30') ? 'selected' : ''; ?>>30 minutos</option>
                                                    <option value="60" <?php echo ($res[3] == '60') ? 'selected' : ''; ?>>1 hora</option>
                                                    <option value="90" <?php echo ($res[3] == '90') ? 'selected' : ''; ?>>1 hora y media</option>
                                                    <option value="120" <?php echo ($res[3] == '120') ? 'selected' : ''; ?>>2 horas</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="prestamo_<?php echo $res[0]; ?>" class="form-label">Reserva</label>
                                                <input type="number" name=reserva class="form-control" id="prestamo_<?php echo $res[0]; ?>" value="<?php echo $res[4]; ?>" min="0" max="1" required>
                                            </div>
                                            <button type="submit" name="modificar" value="modificar" class="btn btn-primary">Actualizar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } while ($res = mysqli_fetch_array($ejecuta));
                }
                ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            <?php 
            if ($pagina != 1) {
                ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?php echo 1; ?>">Primera</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>">Anterior</a>
                </li>
                <?php
            }
            for ($i = 1; $i <= $totalPaginas; $i++) {
                if ($i == $pagina) {
                    echo '<li class="page-item active" aria-current="page"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';    
                } else {
                    echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>'; 
                }
            }
            if ($pagina != $totalPaginas) {
                ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>">Siguiente</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?php echo $totalPaginas; ?>">Ultima</a>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
</div>
            </div>
        </div>
    </div>
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
