FROM php:8.2-cli

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html

WORKDIR /var/www/html

# Strip Windows CRLF line endings and make executable
RUN sed -i 's/\r//' entrypoint.sh && chmod +x entrypoint.sh

EXPOSE 80

# Use explicit bash to avoid shebang CRLF issues
ENTRYPOINT ["/bin/bash", "/var/www/html/entrypoint.sh"]