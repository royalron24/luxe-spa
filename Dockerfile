FROM php:8.2-apache

# Fix MPM conflict: delete all MPM symlinks, copy (not symlink) only prefork
RUN find /etc/apache2/mods-enabled/ -name 'mpm_*' -delete \
    && cp /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load \
    && cp /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf \
    && a2enmod rewrite

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Point document root to CodeIgniter's public/ folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' \
        /etc/apache2/sites-available/000-default.conf \
    && printf '<Directory /var/www/html/public>\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n' \
       >> /etc/apache2/sites-available/000-default.conf

COPY . /var/www/html

WORKDIR /var/www/html

# Strip Windows CRLF and make executable
RUN sed -i 's/\r//' entrypoint.sh && chmod +x entrypoint.sh

# Verify Apache config is valid before building image
RUN apache2ctl configtest

EXPOSE 80

ENTRYPOINT ["/bin/bash", "/var/www/html/entrypoint.sh"]