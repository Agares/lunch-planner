FROM php:7.1-fpm
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install -j$(nproc) pdo_pgsql

WORKDIR /var/www/lunch/