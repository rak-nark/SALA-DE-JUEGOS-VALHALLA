# 🎮 SALA DE JUEGOS VALHALLA

Sistema de gestión para sala de juegos con tres componentes principales: Backend API (Laravel), Frontend (Angular) y Panel Administrativo (PHP).

## 📋 Tabla de Contenidos

- [Características](#características)
- [Arquitectura](#arquitectura)
- [Requisitos](#requisitos)
- [Instalación con Docker](#instalación-con-docker)
- [Instalación Manual](#instalación-manual)
- [Uso](#uso)
- [Estructura del Proyecto](#estructura-del-proyecto)

## ✨ Características

- **Backend API** con Laravel 9+ y PHP 8.2
- **Frontend** moderno con Angular 12+
- **Panel CRUD** administrativo en PHP puro
- **Base de datos** MySQL 8.3
- **Dockerización** completa de todos los servicios
- Gestión de consolas, préstamos, ventas y mantenimiento

## 🏗️ Arquitectura

El proyecto está dividido en 4 servicios principales:

- **Frontend**: Aplicación Angular en el puerto 4200
- **Backend**: API Laravel en el puerto 8000
- **CRUD**: Panel administrativo PHP en el puerto 8080
- **Database**: MySQL en el puerto 3306

## 📦 Requisitos

### Para usar con Docker (Recomendado)
- Docker >= 20.10
- Docker Compose >= 1.29

### Para instalación manual
- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 16
- npm >= 8
- MySQL >= 8.0
- Apache/Nginx

## 🐳 Instalación con Docker

Este proyecto utiliza **imágenes locales** construidas desde los Dockerfiles incluidos en cada carpeta.

### 1. Clonar el repositorio

```bash
git clone https://github.com/rak-nark/SALA-DE-JUEGOS-VALHALLA.git
cd SALA-DE-JUEGOS-VALHALLA
```

### 2. Levantar todos los servicios

```bash
# Construir y levantar todos los contenedores
docker-compose up --build

# O en modo detached (segundo plano)
docker-compose up --build -d
```

### 3. Acceder a los servicios

Una vez levantados los contenedores, los servicios estarán disponibles en:

- **Frontend Angular**: http://localhost:4200
- **Backend Laravel API**: http://localhost:8000
- **Panel CRUD PHP**: http://localhost:8080
- **MySQL Database**: localhost:3306

### Comandos Docker útiles

```bash
# Ver logs de todos los servicios
docker-compose logs -f

# Ver logs de un servicio específico
docker-compose logs -f frontend
docker-compose logs -f backend
docker-compose logs -f crud
docker-compose logs -f db

# Detener todos los servicios
docker-compose down

# Detener y eliminar volúmenes (limpieza completa)
docker-compose down -v

# Reconstruir un servicio específico
docker-compose build frontend
docker-compose build backend
docker-compose build crud
docker-compose build db

# Reiniciar un servicio
docker-compose restart backend

# Ejecutar comandos dentro de un contenedor
docker-compose exec backend php artisan migrate
docker-compose exec backend php artisan db:seed
docker-compose exec backend composer install
docker-compose exec frontend npm install

# Ver estado de los contenedores
docker-compose ps
```

### ⚠️ Alternativa: Usar Imágenes Pre-construidas de Docker Hub

Si prefieres usar las imágenes ya construidas alojadas en Docker Hub en lugar de construir localmente, puedes modificar el [docker-compose.yml](docker-compose.yml) para usar las siguientes imágenes:

```yaml
frontend:
  image: raknark/sdj-frontend:latest

backend:
  image: raknark/sdj-backend:latest

db:
  image: raknark/sdj-db:latest
```

**⚠️ ADVERTENCIA IMPORTANTE:** Las imágenes de Docker Hub están alojadas en un servidor remoto que debe estar encendido para poder descargarlas. Si experimentas problemas para descargar las imágenes, **debes contactar al administrador (rak-nark) para solicitar que encienda la máquina del servidor**.

**Ventajas de las imágenes pre-construidas:**
- Despliegue más rápido (no necesitas construir localmente)
- Imágenes probadas y optimizadas

**Desventajas:**
- Requiere conexión a internet
- Dependencia del servidor del administrador
- No incluye cambios locales que hagas en el código

**Recomendación:** Para desarrollo local, usa las imágenes que se construyen localmente (configuración actual). Para producción o pruebas rápidas, usa las imágenes pre-construidas de Docker Hub.

---

## 💻 Instalación Manual

Si prefieres ejecutar los servicios sin Docker:

### 1. Base de Datos

```bash
# Crear la base de datos
mysql -u root -p -e "CREATE DATABASE valhalla;"

# Importar el esquema
mysql -u root -p valhalla < DB/valhalla.sql
```

### 2. Backend (Laravel API)

```bash
cd BACKEND/valhalla_laravel

# Instalar dependencias
composer install

# Configurar variables de entorno
cp .env.example .env

# Editar .env y configurar:
# DB_HOST=localhost
# DB_DATABASE=valhalla
# DB_USERNAME=root
# DB_PASSWORD=tu_password

# Generar key
php artisan key:generate

# Migrar base de datos (opcional si ya importaste el SQL)
php artisan migrate

# Poblar con datos de prueba (opcional)
php artisan db:seed

# Iniciar servidor
php artisan serve --host=0.0.0.0 --port=8000
```

### 3. Frontend (Angular)

```bash
cd FRONTEND/valhalla_angular

# Instalar dependencias
npm install

# Iniciar servidor de desarrollo
npm start
# O con ng serve
ng serve --host 0.0.0.0 --port 4200
```

### 4. Panel CRUD (PHP)

```bash
# Copiar carpeta CRUD a tu directorio web
cp -r CRUD /var/www/html/valhalla-crud

# O configurar un virtual host en Apache/Nginx
# El DocumentRoot debe apuntar a CRUD/views
```

## 🚀 Uso

### Desarrollo con Docker

```bash
# Levantar en modo desarrollo
docker-compose up

# Los cambios en el código se reflejarán automáticamente
# Frontend: hot reload habilitado
# Backend: los cambios requieren refrescar
```

### Acceso a la Base de Datos

```bash
# Desde host
mysql -h 127.0.0.1 -P 3306 -u root valhalla

# Desde dentro del contenedor
docker-compose exec db mysql -u root valhalla
```

### Ejecutar Migraciones y Seeders

```bash
# Con Docker
docker-compose exec backend php artisan migrate:fresh --seed

# Sin Docker
cd BACKEND/valhalla_laravel
php artisan migrate:fresh --seed
```

## 📁 Estructura del Proyecto

```
SALA-DE-JUEGOS-VALHALLA/
├── docker-compose.yml          # Orquestación de servicios Docker
├── README.md                   # Este archivo
│
├── BACKEND/
│   └── valhalla_laravel/       # API Laravel
│       ├── Dockerfile          # Imagen local del backend
│       ├── app/                # Lógica de la aplicación
│       ├── routes/             # Rutas API
│       ├── database/           # Migraciones y seeders
│       └── .env.example        # Variables de entorno
│
├── FRONTEND/
│   └── valhalla_angular/       # Aplicación Angular
│       ├── Dockerfile          # Imagen local del frontend
│       ├── src/
│       │   ├── app/            # Componentes Angular
│       │   └── environments/   # Configuración de entornos
│       └── package.json
│
├── CRUD/                       # Panel administrativo PHP
│   ├── Dockerfile              # Imagen local del CRUD
│   ├── views/                  # Vistas PHP
│   ├── controller/             # Controladores
│   ├── model/                  # Modelos
│   ├── connection/             # Conexión DB
│   └── configs/                # CSS/JS/Imágenes
│
└── DB/
    ├── Dockerfile              # Imagen local de MySQL
    └── valhalla.sql            # Esquema de base de datos
```

## 🔧 Configuración Avanzada

### Variables de Entorno del Backend

Edita `BACKEND/valhalla_laravel/.env`:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=mysql-db        # Nombre del servicio en Docker
DB_PORT=3306
DB_DATABASE=valhalla
DB_USERNAME=root
DB_PASSWORD=
```

### Variables de Entorno del Frontend

Edita `FRONTEND/valhalla_angular/src/environments/environment.ts`:

```typescript
export const environment = {
  production: false,
  apiUrl: 'http://localhost:8000/api'
};
```

## 🐛 Solución de Problemas

### El contenedor del backend no inicia

```bash
# Ver logs detallados
docker-compose logs backend

# Verificar que las dependencias se instalaron
docker-compose exec backend composer install
```

### Error de conexión a la base de datos

```bash
# Verificar que el contenedor de DB esté corriendo
docker-compose ps db

# Reiniciar el servicio de base de datos
docker-compose restart db
```

### El frontend no se conecta al backend

Verifica que la URL del API en `src/environments/environment.ts` sea correcta:
- Con Docker: `http://localhost:8000/api`
- Sin Docker: depende de tu configuración

## 📝 Licencia

Este proyecto es privado y está bajo la gestión de rak-nark.

## 👥 Contribuciones

Para contribuir al proyecto, contacta al administrador del repositorio.

---

**Desarrollado por el equipo Valhalla** 🎮

