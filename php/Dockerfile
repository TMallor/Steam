FROM php:8.2-fpm

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

# Définir le répertoire de travail
WORKDIR /var/www/html

# Configuration PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./php.ini /usr/local/etc/php/conf.d/

# Utiliser des permissions appropriées
RUN chown -R www-data:www-data /var/www/html

# Ne pas copier les fichiers ici - cela sera fait via les volumes dans docker-compose.yml
# COPY ../www /var/www/html

# Autres instructions si nécessaire (par exemple, pour installer des extensions PHP)
