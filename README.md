## ⚙️ Configuración

### Backend (Laravel API)
```bash
cd backend/valhalla_laravel
composer install
copy .env.example .env
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
