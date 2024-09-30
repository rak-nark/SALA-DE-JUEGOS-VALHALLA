<?php 
include ("../connection/conexion.php");
 include ("../controller/categoriaControlador.php"); 
?>
<?php 
$c = new conexion();
$cone =$c -> conectando();
$sql = "select max(idCliente) from cliente";
$rs1 = mysqli_query(mysql:$cone,query:$sql);
$arreglo=mysqli_fetch_row(result:$rs1);
if($arreglo[0]>0){
  $suma = 0;
  $numero = $arreglo[0];
  $suma = 1 + $arreglo[0];
}else{
  $suma = 0;
  $numero = $arreglo[0];
  $suma = 1 + $arreglo[0];
  $obj->idCliente = $suma;
}
$obj->idCliente = $suma;
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
    font-family: 'Arial', sans-serif;
    background-image: url('../configs/image/fondo.jpg'); /* Cambia la ruta a tu imagen de fondo */
    background-size: cover;
    background-position: center;
    color: #333;
}
.wrapper {
    display: flex;
    height: 100vh;
}
.sidebar {
    width: 250px;
    background: rgba(42, 127, 98, 0.9);
    color: white;
    transition: all 0.3s;
    height: 100%;
    overflow-y: auto;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
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
.main-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    overflow-x: hidden;
}
.navbar {
    background-color: rgba(83, 128, 131, 0.9);
    color: white;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}
.navbar-left, .navbar-right {
    display: flex;
    align-items: center;
}
.profile {
    margin-right: 1rem;
    cursor: pointer;
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
#menuToggle {
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    margin-right: 1rem;
}
.content {
    padding: 2rem;
    flex-grow: 1;
    overflow-y: auto;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}
/* Estilos para tablas */
.table {
    margin-top: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.table th, .table td {
    padding: 1rem;
    text-align: left;
}
.table th {
    background-color: rgba(83, 128, 131, 0.6);
    color: white;
}
/* Estilos para el botón modal */
.btn-primary {
    background-color: #2a7f62;
    border: none;
}
.btn-primary:hover {
    background-color: #1d5a48;
}
.btn-danger {
    background-color: #d9534f;
}
.btn-danger:hover {
    background-color: #c9302c;
}
.btn-warning {
    background-color: #f0ad4e;
}
.btn-warning:hover {
    background-color: #ec971f;
}
/* Pagination */
.pagination {
    margin-top: 20px;
}
.pagination .page-item.active .page-link {
    background-color: #2a7f62;
    border-color: #2a7f62;
}
.pagination .page-link:hover {
    background-color: #1d5a48;
    color: white;
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
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="../configs/image/Imagen2-removebg-preview (1).png" alt="Logo" width="150" height="100">
            </a>
            <!-- Botón para toggler en vista móvil -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Contenido del navbar -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Menú de navegación -->
                <!-- Barra de búsqueda -->
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" name="nombreCliente" id="idCliente" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit" name="buscar" id="buscar">Buscar</button>
                </form>
            </div>
        </div>
    </nav>
    <center>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Ingresar cliente
        </button>
    </center>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingrese los cliente registrados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="mb-3">
                            <input type="hidden" name="idCliente" value="<?php echo $obj->idCliente ?>" class="form-control" id="exampleInputText1">
                        </div>
                        <div class="mb-3">
                            <label for="nombreCliente" class="form-label">Nombre</label>
                            <input type="text" name="nombreCliente" class="form-control" id="nombreCliente">
                        </div>
                        <div class="mb-3">
                            <label for="apellidoCliente" class="form-label">Apellido</label>
                            <input type="text" name="apellidoCliente" class="form-control" id="apellidoCliente">
                        </div>
                        <div class="mb-3">
                            <label for="correoCliente" class="form-label">Correo</label>
                            <input type="email" name="correoCliente" class="form-control" id="correoCliente">
                        </div>
                        <div class="mb-3">
                            <label for="contrasenaCliente" class="form-label">Contrasena</label>
                            <input type="password" name="contrasenaCliente" class="form-control" id="contrasenaCliente">
                        </div>
                        <button type="submit" class="btn btn-primary" name="guarda" value="guarda">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabla -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Contrasena</th>
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
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="idCliente" value="<?php echo $res[0]; ?>">
                                    <button type="submit" name="elimina" value="elimina" class="btn btn-danger">Eliminar</button>
                                </form>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="idCliente" value="<?php echo $res[0]; ?>">
                                    <!-- Botón Editar -->
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
                                        <h5 class="modal-title">Editar Cliente</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            <input type="hidden" name="idCliente" value="<?php echo $res[0]; ?>">
                                            <div class="mb-3">
                                                <label for="nombreCliente_<?php echo $res[0]; ?>" class="form-label">Nombre</label>
                                                <input type="text" name="nombreCliente" class="form-control" id="nombreCliente_<?php echo $res[0]; ?>" value="<?php echo $res[1]; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="apellidoCliente_<?php echo $res[0]; ?>" class="form-label">Apellido</label>
                                                <input type="text" name="apellidoCliente" class="form-control" id="apellidoCliente_<?php echo $res[0]; ?>" value="<?php echo $res[2]; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="correoCliente_<?php echo $res[0]; ?>" class="form-label">Correo</label>
                                                <input type="email" name="correoCliente" class="form-control" id="correoCliente_<?php echo $res[0]; ?>" value="<?php echo $res[3]; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="contrasenaCliente_<?php echo $res[0]; ?>" class="form-label">Contrasena</label>
                                                <input type="password" name="contrasenaCliente" class="form-control" id="contrasenaCliente_<?php echo $res[0]; ?>" value="<?php echo $res[4]; ?>">
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
            if($pagina != 1) {
            ?>
            <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo 1; ?>">Primera</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>">Anterior</a>
            </li>
            <?php
            }
            for($i = 1; $i <= $totalPaginas; $i++) {
                if($i == $pagina) {
                    echo '<li class="page-item active" aria-current="page"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';    
                } else {
                    echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>'; 
                }
            }
            if($pagina != $totalPaginas) {
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
