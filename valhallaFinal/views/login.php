<?php
include('../connection/conexion.php');
session_start();
?>
<?php
if (isset($_POST['Ingresar'])) {
    $correoCliente = $_POST['correoCliente'];
    $contrasenaCliente = $_POST['contrasenaCliente'];
    $_SESSION['correoCliente'] = $correoCliente;
    $c = new Conexion();
    $cone = $c->conectando();
    $stmt = $cone->prepare("SELECT contrasenaCliente FROM cliente WHERE correoCliente = ?");
    $stmt->bind_param("s", $correoCliente); // "s" specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['contrasenaCliente'];
        if (password_verify($contrasenaCliente, $hashedPassword)) {
            header("location:iniciosesion.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
    $stmt->close();
    mysqli_free_result($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url('../configs/image/xox.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .wrapper-login {
            width: 350px;
            background: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        h3 {
            color: #2a7f62;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            background: transparent;
            border: none;
            border-bottom: 2px solid #2a7f62;
            border-radius: 0;
            padding: 10px 15px;
            font-size: 16px;
            height: 40px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #228b54;
        }
        .form-floating-label label {
            font-size: 16px;
            color: #666;
        }
        .btn-login {
            background-color: #2a7f62;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin-top: 15px;
        }
        .btn-login:hover {
            background-color: #228b54;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .remember-me {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        .register-link a {
            color: #2a7f62;
            text-decoration: none;
            font-weight: bold;
        }
        .input-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #2a7f62;
        }
		.form-floating-label {
            position: relative;
            margin-bottom: 25px;
        }
        .form-floating-label label {
            position: absolute;
            top: 0;
            left: 15px;
            padding: 7px 0;
            font-size: 16px;
            color: #999;
            pointer-events: none;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
<form action="" method="post" class="formulario">
    <div class="wrapper-login">
        <h3>Iniciar Sesión</h3>
        <div class="login-form">
            <div class="form-group form-floating-label">    
                <input id="correoCliente" name="correoCliente" type="email" class="form-control" placeholder="Correo" required>
                <i class="fas fa-envelope input-icon"></i>
            </div>
            <div class="form-group form-floating-label">
                <input id="contrasenaCliente" name="contrasenaCliente" type="password" class="form-control" placeholder= "Contraseña" required><i class="fas fa-lock input-icon"></i>
                
            </div>
            <div class="remember-me">
                <input type="checkbox" id="rememberMe" name="rememberMe">
                <label for="rememberMe">Recordar usuario</label>
            </div>
            <div class="form-action">
                <input type="submit" name="Ingresar" class="btn btn-login w-100" value="Iniciar Sesión">
            </div>
        </div>  
        <div class="register-link">
            <span>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></span>
        </div>
    </div>  
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></script>
</body>
</html>