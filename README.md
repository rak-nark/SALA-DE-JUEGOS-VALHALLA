# Sala de Juegos Valhalla 🎮

Sistema integral para gestión de reservas en sala de videojuegos con módulos para usuarios y administradores.

## 🌟 Tecnologías Principales
- **Frontend**: Angular 12+
- **Backend**: Laravel 9+ (API REST)
- **Base de datos**: MySQL 8+
- **Mobile**: Android (Kotlin)
- **CRUD**: PHP nativo (para módulo administrativo)

## 🚀 Funcionalidades Clave
### Para Usuarios
- Registro e inicio de sesión seguro
- Reserva de consolas (Xbox 360/One)
- Historial de reservas
- Validación de disponibilidad en tiempo real

### Para Administradores
- Panel CRUD completo
- Gestión de usuarios y reservas
- Reportes de actividad
- Configuración del sistema

## 🗂 Estructura del Proyecto
```
├── backend/ # API Laravel
├── frontend/ # Aplicación Angular
├── CRUD/ # Panel administrativo (PHP)
│ ├── configs/ # Assets (CSS/JS/imágenes)
│ ├── connection/ # Configuración DB
│ ├── controller/ # Lógica PHP
│ ├── model/ # Clases DB
│ └── views/ # Interfaces
└── mobile/ # App Android
```

## ⚙️ Configuración

### Backend (Laravel API)
```bash
cd backend/valhalla_laravel
composer install
cp .env.example .env
php artisan key:generate
# Configurar .env con credenciales DB
php artisan migrate --seed
php artisan serve
 ```
Frontend (Angular)
```
cd frontend/valhalla_angular
npm install
ng serve
```
Panel Administrativo (CRUD PHP)
```
Copiar carpeta CRUD/ a htdocs:
```
Importar valhalla.sql via phpMyAdmin

Configurar conexión en CRUD/connection/conexion.php

Acceder via: http://localhost/CRUD/views/login.php

🔐 Credenciales de Prueba
Admin: juanitoalimana@gmail.com / 123456789
Usuario: angelita@gmail.com / 123456789

📄 Licencia
MIT License © 2025 Sala de Juegos Valhalla
