<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    background-image: url(../configs/image/Background\ image.png);
    background-position: center;
    background-size: cover;
    background-attachment: fixed;
}

.title-container {
    display: flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
    width: 100%;
    padding: 10px;
    background-color: #edededaa;
    color: #000;
}

section {
    display: flex;
    width: 100%;
    height: 300px;
    opacity: 0;
    animation: fadeInSection 2s forwards;
}

section img {
    width: 0;
    flex-grow: 1;
    object-fit: cover;
    opacity: 0.7;
    transition: 0.5s ease;
}

section img:hover {
    width: 50px;
    opacity: 1;
    filter: contrast(120%);
}

.subtitle {
    text-align: center;
    width: 100%;
    padding: 27px;
    box-sizing: border-box;
    background-color: #edededaa;
    color: #000;
}

.button-container {
    display: inline-block;
    padding: 17px;
    border-radius: 10px;
}

.styled-button {
    background-color: #fff;
    text-align: center;
    width: 180px;
    padding: 15px 32px;
    border: none;
    border-radius: 12px;
    transition-duration: 0.4s;
    cursor: pointer;
}

button {
    margin: 5px;
}

a {
    text-decoration: none;
    color: #000;
}

.styled-button:hover {
    background-color: #cdcdcd;
    color: #fff;
}

@keyframes fadeIn {
    to {
        opacity: 0.5;
    }
}

@keyframes fadeInSection {
    to {
        opacity: 1;
    }
}
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">

    <title>SALA DE JUEGOS VALHALLA</title>
</head>
<body>
    <div class="title-container">
        <div class="title">
            <h1>SALA DE JUEGOS VALHALLA</h1>
        </div>
        <img src="../configs/image/Imagen2-removebg-preview (1).png" alt="Icono" width="200">
    </div>
    <section>
        <img src="../configs/image/creedvalhalla.jpg" alt="">
        <img src="../configs/image/fcmobile.png" alt="">
        <img src="../configs/image/fornite.jpg" alt="">
        <img src="../configs/image/forza_5.png" alt="">
        <img src="../configs/image/warsone.png" alt="">
        <img src="../configs/image/Halo_infinite.png" alt="">
        <img src="../configs/image/mortal_kombat.png" alt="">
    </section>
    <div class="subtitle">
        <h2>TUS JUEGOS FAVORITOS EN UN SOLO LUGAR</h2>
       <div class="button-container">
    <a href="login.php" class="styled-button">INICIAR SESIÓN</a>
    <a href="registro.php" class="styled-button">CREAR USUARIO</a>
</div>

    </div>
</body>
</html>
