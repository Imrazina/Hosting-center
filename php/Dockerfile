FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql mysqli && \
    apk add --no-cache bash

WORKDIR /var/www/html