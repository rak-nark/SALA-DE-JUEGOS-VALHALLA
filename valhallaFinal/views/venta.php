<?php 
include ("../connection/conexion.php");
include ("../controller/ventaControlador.php");
?>
?>
<?php 
$c = new conexion();
$cone =$c -> conectando();
$sql = "select max(id) from venta";
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
  $obj->id = $suma;
}
$obj->id = $suma;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <link rel="stylesheet" href="../configs/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f7fa;
}
.wrapper {
    display: flex;
    height: 100vh;
}
/* Sidebar */
.sidebar {
    width: 250px;
    background: #34495e; /* Color de la sidebar */
    color: #ecf0f1;
    transition: all 0.3s;
    height: 100%;
    overflow-y: auto;
    padding-top: 20px; /* Espacio superior */
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
    color: #ecf0f1;
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
    background-color: #2980b9; /* Color de la navbar */
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
    background-color: #2980b9; /* Color igual que la navbar */
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
    background-color: #3498db; /* Color de hover para submenu */
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
}
/* Tabla */
.table {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.table th {
    background-color: #2980b9; /* Color de las cabeceras */
    color: white;
}
.table th, .table td {
    padding: 15px;
}
.table-hover tbody tr:hover {
    background-color: rgba(52, 152, 219, 0.1);
}
/* Pagination */
.pagination {
    justify-content: end;
}
.page-link {
    color: #2980b9;
}
.page-link:hover {
    background-color: #ecf0f1;
}
.page-item.active .page-link {
    background-color: #2980b9;
    color: white;
}
/* Modales */
.modal-header {
    background-color: #2980b9;
    color: white;
}
.modal-content {
    border-radius: 8px;
}
.modal-body input {
    border: 1px solid #bdc3c7;
}
/* Botones */
.btn-primary {
    background-color: #27ae60; /* Tonalidad de verde */
    border: none;
}
.btn-primary:hover {
    background-color: #2ecc71; /* Color de hover para botón */
}
/* Imagen en el logo */
.navbar-brand img {
    pointer-events: none; /* Evita la interacción con la imagen */
}
/* Ajustes adicionales */
.table-responsive {
    margin-top: 20px; /* Espacio superior */
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
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" name="nombreCliente" id="idCliente" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit" name="buscar" id="buscar">Buscar</button>
                </form>
            </div>
        </div>
    </nav>
        <center>
            <nav>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Ingresar venta
                </nav> 
            </nav>
        </center>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ingrese los ventas registrados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="mb-3">
                                <input type="hidden" name="id" value="<?php echo $obj->id ?>" class="form-control" id="exampleInputText1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputText1" class="form-label">Fecha</label>
                                <input type="date" name="fecha" class="form-control" id="exampleInputText1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputText1" class="form-label">Monto</label>
                                <input type="number" name="monto" class="form-control" id="exampleInputText1" >
                            </div>
                            <button type="submit" class="btn btn-primary" name="guarda" value="guarda">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mt-3">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Monto</th>
                        <th scope="col">Acciones</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($res == 0) {
                        echo "<tr><td colspan='5' class='text-center'>No hay registros</td></tr>";
                    } else {
                        do {
                    ?>
                            <tr>
                                <td><?php echo $res[0] ?></td>
                                <td><?php echo $res[1] ?></td>
                                <td><?php echo $res[2] ?></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="<?php echo $res[0]; ?>">
                                        <button type="submit" src="iniciosesion.php" name="elimina" value="elimina"  class="btn btn-danger">Eliminar</button> 
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="<?php echo $res[0]; ?>">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal_<?php echo $res[0]; ?>">Editar</button>
                                        <div class="modal fade" id="editModal_<?php echo $res[0]; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Editar Venta</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post">
                                                            <input type="hidden" name="id" value="<?php echo $res[0]; ?>">
                                                            <div class="mb-3">
                                                                <label for="fecha_<?php echo $res[0]; ?>" class="form-label">Fecha</label>
                                                                <input type="date" name="fecha" class="form-control" id="fecha_<?php echo $res[0]; ?>" value="<?php echo $res[1]; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="monto_<?php echo $res[0]; ?>" class="form-label">Monto</label>
                                                                <input type="text" name="monto" class="form-control" id="monto_<?php echo $res[0]; ?>" value="<?php echo $res[2]; ?>">
                                                            </div>
                                                            <button type="submit" name="modificar" value="modificar" class="btn btn-primary">Actualizar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
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
                        <a class="page-link" href="?pagina=<?php echo 1; ?>">&laquo;</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>">&lsaquo;</a>
                    </li>
                <?php
                }
                for ($i = 1; $i <= $totalPaginas; $i++) {
                    if ($i == $pagina) {
                        echo '<li class="page-item active" aria-current="page"><a class="page-link" href="?pagina=' . $i . '">' . $i . '</a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="?pagina=' . $i . '">' . $i . '</a></li>';
                    }
                }
                if ($pagina != $totalPaginas) {
                ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>">&rsaquo;</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $totalPaginas; ?>">&raquo;</a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </nav>
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