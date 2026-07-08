FROM php:8.2-fpm-alpine

# Install nginx and supervisor (no Apache, no MPM issues)
RUN apk add --no-cache nginx supervisor

# Install PHP extensions (including intl required by CodeIgniter 4.7.3)
RUN apk add --no-cache icu-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql intl

# Copy nginx and supervisor configs
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY . /var/www/html

WORKDIR /var/www/html

# Install Composer dependencies
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-interaction --optimize-autoloader

RUN sed -i 's/\r//' entrypoint.sh && chmod +x entrypoint.sh

EXPOSE ${PORT:-80}

ENTRYPOINT ["/bin/sh", "/var/www/html/entrypoint.sh"]