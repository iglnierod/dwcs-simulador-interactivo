# Usa la imagen oficial con Apache + PHP
FROM php:8.2-apache

# Copia el contenido de tu carpeta 'html' al directorio del servidor web
COPY html/ /var/www/html/

# Da permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Habilita módulos que podrías necesitar en el futuro
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Exponemos el puerto que Apache usa por defecto
EXPOSE 80
