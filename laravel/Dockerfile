# Build stage
FROM php:8.2 AS build

WORKDIR /var/www/laravel

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-autoloader

COPY . .

RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize

# Run stage
FROM php:8.2

WORKDIR /var/www/laravel

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

COPY --from=build /var/www/laravel .
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000

