FROM php:8.2-apache

# Install PHP extensions needed for CodeIgniter + MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable CodeIgniter URL rewriting
RUN a2enmod rewrite

# Disable all MPM modules first, then enable only prefork
RUN a2dismod mpm_event mpm_worker mpm_prefork || true
RUN a2enmod mpm_prefork

# Set CodeIgniter public folder as Apache root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80