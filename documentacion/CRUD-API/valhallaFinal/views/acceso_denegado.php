<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #ffffff; /* Fondo blanco */
            color: #000000; /* Texto en negro */
            font-family: Arial, sans-serif;
        }
        .access-denied-container {
            text-align: center;
            background: #f8f9fa; /* Fondo ligeramente gris */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .access-denied-title {
            font-size: 2rem;
            margin-bottom: 15px;
            color: #e74c3c; /* Texto rojo */
        }
        .access-denied-message {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .btn-login {
            background-color: #27ae60;
            border: none;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
        }
        .btn-login:hover {
            background-color: #2ecc71;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="access-denied-container">
        <h1 class="access-denied-title">Acceso Denegado</h1>
        <p class="access-denied-message">No tienes permiso para acceder a esta página.</p>
        <a href="inicio.php" class="btn-login">Volver al inicio</a>
    </div>
</body>
</html>
