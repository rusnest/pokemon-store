# Dockerfile
FROM php:cli

RUN apt-get update -y && apt-get install -y libmcrypt-dev libpq-dev zip unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /app
COPY . /app

RUN composer install

EXPOSE 5000
CMD php artisan serve --host=0.0.0.0 --port=5000
