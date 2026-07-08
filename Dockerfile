FROM php:8.2-apache

# Install extensions FIRST — apt triggers inside may reset MPM config
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Fix MPM AFTER extension install so apt triggers can't undo it
RUN find /etc/apache2/mods-enabled/ -name 'mpm_*' -delete \
    && cp /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load \
    && cp /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf \
    && a2enmod rewrite \
    && apache2ctl configtest

# Point document root to CodeIgniter's public/ folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' \
        /etc/apache2/sites-available/000-default.conf \
    && printf '<Directory /var/www/html/public>\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n' \
       >> /etc/apache2/sites-available/000-default.conf

COPY . /var/www/html

WORKDIR /var/www/html

RUN sed -i 's/\r//' entrypoint.sh && chmod +x entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/bin/bash", "/var/www/html/entrypoint.sh"]