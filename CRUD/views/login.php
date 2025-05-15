<?php
include('../connection/conexion.php');
session_start();
if (isset($_POST['Ingresar'])) {
    $correoCliente = $_POST['correoCliente'];
    $contrasenaCliente = $_POST['contrasenaCliente'];
    $_SESSION['correoCliente'] = $correoCliente;
    $c = new Conexion();
    $cone = $c->conectando();
    // Consulta para obtener contraseña y rol
    $stmt = $cone->prepare("SELECT contrasenaCliente, rol FROM cliente WHERE correoCliente = ?");
    $stmt->bind_param("s", $correoCliente);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['contrasenaCliente'];
        $rol = $row['rol'];
        // Verifica la contraseña
        if (password_verify($contrasenaCliente, $hashedPassword)) {
            // Verifica si el rol es 'administrador'
            if ($rol === 'administrador') {
                // Guarda datos esenciales en la sesión
                $_SESSION['rol'] = $rol;
                // Redirige al panel de administrador
                header("Location: home.php");
                exit();
            } else {
                // Si el rol no es 'administrador', muestra un mensaje de error
                echo "<script>alert('Solo los administradores pueden iniciar sesión.');</script>";
            }
        } else {
            echo "<script>alert('Contraseña incorrecta.');</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado.');</script>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../configs/CSS/login.css">
</head>
<body>
    <div class="login-page">
        <form action="" method="post" class="formulario">
            <div class="wrapper-login">
                <h3>Iniciar Sesión</h3>
                <div class="login-form">
                    <div class="form-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="correoCliente" name="correoCliente" type="email" class="form-control" placeholder="Correo" required>
                    </div>
                    <div class="form-group password-group">
    <i class="fas fa-lock input-icon"></i>
    <input id="contrasenaCliente" name="contrasenaCliente" type="password" class="form-control" placeholder="Contraseña" required>
    <span class="toggle-password" onclick="togglePassword()">
        <i class="fas fa-eye"></i>
    </span>
</div>
                    <div class="form-action">
                        <input type="submit" name="Ingresar" class="btn btn-login w-100" value="Iniciar Sesión">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
function togglePassword() {
    const passwordInput = document.getElementById('contrasenaCliente');
    const icon = document.querySelector('.toggle-password i');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

</body>
</html>
