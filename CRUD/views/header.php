<?php
if (!isset($activePage)) {
  $activePage = '';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Administración</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Estilos personalizados -->
  <style>
    .animated-navbar {
      background: linear-gradient(to right, #198754, #157347);
      transition: all 0.4s ease;
    }

    .navbar-nav .nav-item {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .navbar-nav .nav-link {
      color: #f8f9fa;
      font-weight: 500;
      transition: all 0.3s ease;
      border-bottom: 3px solid transparent;
    }

    .navbar-nav .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
      border-bottom: 3px solid #ffffff66;
    }

    .navbar-nav .active-nav {
      background-color: rgba(255, 255, 255, 0.15);
      border-bottom: 3px solid #ffffff;
      font-weight: 600;
      color: #fff !important;
    }

    .dropdown-menu {
      animation: fadeIn 0.3s ease-in-out;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm p-0 animated-navbar">
  <div class="container-fluid px-0">
    <!-- Toggle para móvil -->
    <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav nav-fill w-100">
        <li class="nav-item flex-fill text-center">
          <a class="nav-link px-0 py-3 <?= $activePage === 'home' ? 'active-nav' : '' ?>" href="home.php">
            <i class="fa-solid fa-users me-1"></i>Clientes
          </a>
        </li>
        <li class="nav-item flex-fill text-center">
          <a class="nav-link px-0 py-3 <?= $activePage === 'consola' ? 'active-nav' : '' ?>" href="consola.php">
            <i class="fa-solid fa-tv me-1"></i>Consolas
          </a>
        </li>
        <li class="nav-item flex-fill text-center">
          <a class="nav-link px-0 py-3 <?= $activePage === 'mantenimiento' ? 'active-nav' : '' ?>" href="mantenimiento.php">
            <i class="fa-solid fa-screwdriver-wrench me-1"></i>Mantenimiento
          </a>
        </li>
        <li class="nav-item flex-fill text-center">
          <a class="nav-link px-0 py-3 <?= $activePage === 'prestamo' ? 'active-nav' : '' ?>" href="prestamo.php">
            <i class="fa-solid fa-handshake me-1"></i>Préstamos
          </a>
        </li>
        <li class="nav-item flex-fill text-center">
          <a class="nav-link px-0 py-3 <?= $activePage === 'venta' ? 'active-nav' : '' ?>" href="venta.php">
            <i class="fa-solid fa-cart-shopping me-1"></i>Ventas
          </a>
        </li>
        <li class="nav-item flex-fill text-center">
          <a class="nav-link px-0 py-3 <?= $activePage === 'ganancias' ? 'active-nav' : '' ?>" href="ganancias.php">
            <i class="fa-solid fa-chart-line me-1"></i>Ganancias
          </a>
        </li>
        <!-- Menú perfil -->
        <li class="nav-item dropdown text-center">
          <a class="nav-link dropdown-toggle px-3 py-3" href="#" data-bs-toggle="dropdown">
            <i class="fa-solid fa-user-circle me-1"></i>Perfil
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="login.php"><i class="fa-solid fa-right-to-bracket me-2"></i>Iniciar Sesión</a></li>
            <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Cerrar Sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
