# Imagen base con PHP 8.2 y extensiones recomendadas
FROM php:8.2-cli

# Instala dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia los archivos del proyecto al contenedor
COPY . .

# Instala las dependencias de Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copia el archivo de ejemplo .env si no existe
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Genera la clave de la aplicación
RUN php artisan key:generate

# Expone el puerto 8000 para el servidor de Laravel
EXPOSE 8000

# Comando por defecto para iniciar el servidor de desarrollo

CMD ["/bin/sh", "-c", "if [ ! -f .env ]; then cp .env.example .env; fi && composer install && php artisan key:generate && php artisan serve --host=0.0.0.0 --port=8000"]