FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80