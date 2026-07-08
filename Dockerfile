FROM php:8.2-apache

RUN find /etc/apache2/mods-enabled/ -name 'mpm_*' -delete \
    && ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load \
    && ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html

EXPOSE 80