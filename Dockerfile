FROM php:8.2-apache

RUN rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.* \
    && a2enmod mpm_prefork

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html

EXPOSE 80