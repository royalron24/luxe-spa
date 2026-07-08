FROM php:8.2-cli

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html

WORKDIR /var/www/html

RUN chmod +x /var/www/html/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/var/www/html/entrypoint.sh"]