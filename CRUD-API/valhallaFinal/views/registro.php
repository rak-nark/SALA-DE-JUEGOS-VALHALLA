<?php 
include ("../connection/conexion.php");
include ("../controller/categoriaControlador.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Clientes</title>
    <link rel="stylesheet" href="../configs/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url('../configs/image/Background%20image.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco con algo de transparencia */
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #34495e; /* Título en un color oscuro */
        }
        .form-label {
            color: #2c3e50; /* Etiquetas del formulario en color oscuro */
            font-weight: bold;
        }
        .form-control {
            background-color: #ecf0f1; /* Fondo del campo de texto más claro */
            color: #34495e; /* Texto en un color oscuro */
            border-radius: 5px;
            border: 1px solid #bdc3c7;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #2980b9; /* Borde azul al seleccionar */
            box-shadow: 0 0 5px rgba(41, 128, 185, 0.5); /* Sombra azul al enfocar */
        }
        .btn {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #2980b9;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #1f6399;
        }
        .mb-3 {
            margin-bottom: 1.5rem;
        }
        .text-center {
            margin-top: 20px;
            color: #2c3e50; /* Color del texto del enlace */
        }
    </style>
</head>
<body>
<div class="container">
    <h3>Iniciar Sesion</h3>
    <form method="post">
        <div class="mb-3">
            <input type="hidden" name="idCliente" value="<?php echo $obj->idCliente ?>" class="form-control" id="exampleInputText1">
        </div>
        <div class="mb-3">
            <label for="nombreCliente" class="form-label">Nombre <i class="fas fa-user"></i></label>
            <input type="text" name="nombreCliente" class="form-control" id="nombreCliente" required>
        </div>
        <div class="mb-3">
            <label for="apellidoCliente" class="form-label">Apellido <i class="fas fa-user"></i></label>
            <input type="text" name="apellidoCliente" class="form-control" id="apellidoCliente" required>
        </div>
        <div class="mb-3">
            <label for="correoCliente" class="form-label">Correo <i class="fas fa-envelope"></i></label>
            <input type="email" name="correoCliente" class="form-control" id="correoCliente" required>
        </div>
        <div class="mb-3">
            <label for="contrasenaCliente" class="form-label">Contraseña <i class="fas fa-lock"></i></label>
            <input type="password" name="contrasenaCliente" class="form-control" id="contrasenaCliente" required>
        </div>
        <button type="submit" class="btn btn-primary" name="guarda" value="guarda">Crear usuario</button>
    </form>
    <div class="text-center">
        <p>¿Ya tienes cuenta? <a href="login.php" style="color: #2980b9; text-decoration: underline;">Ingresa aquí</a></p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
