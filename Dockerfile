FROM php:8.3.17-apache

RUN apt-get update && apt-get upgrade -y \
    curl \
    unzip

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY php/ /var/www/html/

WORKDIR /var/www/html

RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader; fi

EXPOSE 80