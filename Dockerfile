FROM php:8.4-apache

# System libraries + PHP extensions Laravel needs
RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev zip unzip libpng-dev libxml2-dev libicu-dev libsqlite3-dev curl \
    && docker-php-ext-install pdo pdo_sqlite zip gd bcmath xml intl \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache virtual host that serves Laravel's public/ directory
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . /var/www/html

# Install PHP dependencies (no dev tooling, no artisan scripts at build time)
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs --no-scripts \
    && chown -R www-data:www-data storage bootstrap/cache database

# Startup script: configure port, run migrations/seed, launch Apache
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080
ENTRYPOINT ["entrypoint.sh"]
