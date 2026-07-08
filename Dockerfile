FROM php:8.2-fpm-alpine

# Install nginx and supervisor (no Apache, no MPM issues)
RUN apk add --no-cache nginx supervisor

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy nginx and supervisor configs
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY . /var/www/html

WORKDIR /var/www/html

RUN sed -i 's/\r//' entrypoint.sh && chmod +x entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/bin/bash", "/var/www/html/entrypoint.sh"]