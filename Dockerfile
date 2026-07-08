FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    libicu-dev \
    unzip \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql intl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy nginx config (overwrite default site)
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Copy supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY . /var/www/html

WORKDIR /var/www/html

RUN composer install --no-dev --no-interaction --optimize-autoloader

# Fix permissions for PHP-FPM (runs as www-data)
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

RUN sed -i 's/\r//' entrypoint.sh && chmod +x entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/bin/bash", "/var/www/html/entrypoint.sh"]