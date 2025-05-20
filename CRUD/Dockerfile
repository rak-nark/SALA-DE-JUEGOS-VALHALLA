FROM php:8.2-apache

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Instalar extensiones necesarias para MySQL y otras dependencias útiles
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar archivos del CRUD al contenedor
COPY . .

# Opcional: Si tienes archivos .htaccess en CRUD/views, asegúrate de que AllowOverride esté habilitado
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Opcional: Mejorar permisos para desarrollo (no recomendado en producción)
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 80