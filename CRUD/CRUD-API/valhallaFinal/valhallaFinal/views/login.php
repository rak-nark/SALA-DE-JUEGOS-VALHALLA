<?php
include('../connection/conexion.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Ingresar'])) {
    $correoCliente = trim($_POST['correoCliente']);
    $contrasenaCliente = trim($_POST['contrasenaCliente']);

    if (!empty($correoCliente) && !empty($contrasenaCliente)) {
        $c = new Conexion();
        $cone = $c->conectando();

        // Consulta para obtener la contraseña y el rol
        $stmt = $cone->prepare("SELECT contrasenaCliente, rol FROM cliente WHERE correoCliente = ?");
        $stmt->bind_param("s", $correoCliente);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['contrasenaCliente'];
            $rol = trim(strtolower($row['rol'])); // Normaliza el rol para evitar errores de comparación

            // Verifica la contraseña
            if (password_verify($contrasenaCliente, $hashedPassword)) {
                // Verifica si el rol es 'administrador'
                if ($rol === 'administrador') {
                    $_SESSION['correoCliente'] = $correoCliente;
                    $_SESSION['rol'] = $rol;

                    // Redirige al panel de administrador
                    header("Location: home.php");
                    exit();
                } else {
                    echo "<script>alert('⚠️ Solo los administradores pueden iniciar sesión.'); window.history.back();</script>";
                    exit();
                }
            } else {
                echo "<script>alert('⚠️ Contraseña incorrecta.'); window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('⚠️ Usuario no encontrado.'); window.history.back();</script>";
            exit();
        }

        $stmt->close();
        $cone->close();
    } else {
        echo "<script>alert('⚠️ Por favor, completa todos los campos.'); window.history.back();</script>";
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALA DE JUEGOS VALHALLA</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .title-container {
            text-align: center;
            padding: 20px;
            background-color: #343a40;
            color: white;
        }
        .wrapper-login {
            width: 350px;
            background: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            margin: 20px auto;
        }
        .form-control {
            background: transparent;
            border: none;
            border-bottom: 2px solid #2a7f62;
            padding: 10px 15px;
            font-size: 16px;
        }
        .btn-login {
            background-color: #2a7f62;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin-top: 15px;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #228b54;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .input-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #2a7f62;
        }
    </style>
</head>
<body>
    <!-- Contenedor del título -->
    <div class="title-container">
        <h1>SALA DE JUEGOS VALHALLA</h1>
        <img src="../configs/image/Imagen2-removebg-preview (1).png" alt="Icono" width="200">
    </div>

    <!-- Formulario de inicio de sesión -->
    <form action="" method="post">
        <div class="wrapper-login">
            <h3>Iniciar Sesión</h3>
            <div class="login-form">
                <div class="position-relative mb-3">
                    <input id="correoCliente" name="correoCliente" type="email" class="form-control" placeholder="Correo" required>
                    <i class="fas fa-envelope input-icon"></i>
                </div>
                <div class="position-relative mb-3">
                    <input id="contrasenaCliente" name="contrasenaCliente" type="password" class="form-control" placeholder="Contraseña" required>
                    <i class="fas fa-lock input-icon"></i>
                </div>
                <button type="submit" name="Ingresar" class="btn btn-login">Iniciar Sesión</button>
            </div>
        </div>
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
