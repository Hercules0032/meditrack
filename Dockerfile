FROM dunglas/frankenphp:1-php8.2

RUN apt-get update && apt-get install -y \
    libzip-dev zip libpng-dev libpq-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql zip gd bcmath xml

WORKDIR /app

COPY . /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080

CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && frankenphp run --config /etc/caddy/Caddyfile --listen :8080