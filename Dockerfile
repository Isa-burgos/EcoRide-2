FROM php:8.3.17-apache

RUN apt-get update && apt-get upgrade -y \
     && apt-get install -y curl unzip libssl-dev pkg-config git
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql
RUN pecl install mongodb || true && docker-php-ext-enable mongodb

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ecoride.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html/

WORKDIR /var/www/html

RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader; fi

EXPOSE 80