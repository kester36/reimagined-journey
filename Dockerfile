FROM php:8.1-fpm

RUN apt update && apt install -y libicu-dev libzip-dev libpq-dev \
    & docker-php-ext-install pdo pgsql pdo_pgsql sqlite3 pdo_sqlite intl opcache

WORKDIR /var/www/app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install \
    & composer app:mirgations
