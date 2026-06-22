FROM php:8.2-fpm-alpine

RUN apk update && apk add --no-cache \
    libzip-dev zip unzip libpng-dev libpq-dev libxml2-dev icu-dev shadow curl

RUN docker-php-ext-install pdo pdo_pgsql zip gd bcmath xml intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app

RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs --no-scripts

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080

CMD php -S 0.0.0.0:8080 -t public/