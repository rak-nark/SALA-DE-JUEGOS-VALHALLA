# Sala de Juegos Valhalla 🎮

Este proyecto gestiona una sala de videojuegos que permite a los usuarios reservar consolas como Xbox 360 y Xbox One. Cuenta con un sistema dividido en frontend (Angular), backend (Laravel API) y una app Android.

## Tecnologías utilizadas 🛠️

- **Frontend:** Angular
- **Backend:** Laravel (API RESTful)
- **Base de datos:** MySQL
- **App móvil:** Android (Java/Kotlin)

## Funcionalidades principales ✅

- Autenticación de usuarios (registro e inicio de sesión)
- Reservas de consolas por fecha y hora
- Vista administrativa con CRUD de reservas y usuarios
- Eliminación controlada de usuarios y reservas
- Validaciones según reglas de horario y disponibilidad

## Estructura del proyecto 📁


## Cómo ejecutar el proyecto 🚀

### Backend Laravel
```bash
cd valhalla_laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

### Frontend Angular

cd valhalla_angular
npm install
ng serve

