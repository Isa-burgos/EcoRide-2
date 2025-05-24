FROM php:8.3.17-apache

RUN apt-get update && apt-get upgrade -y && \
     apt-get install -y curl unzip libssl-dev pkg-config git libicu-dev && \
     docker-php-ext-install intl mysqli pdo pdo_mysql && \
     docker-php-ext-enable mysqli pdo_mysql && \
     pecl install mongodb || true && docker-php-ext-enable mongodb && \
     curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
     a2enmod rewrite

COPY ecoride.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html/

WORKDIR /var/www/html

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer --version && \
     if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction --verbose --ignore-platform-req=ext-mongodb; fi

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]