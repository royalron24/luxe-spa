#!/bin/bash
set -e

# Generate .env file from Render environment variables at container start
cat > /var/www/html/.env << ENVFILE
CI_ENVIRONMENT = ${CI_ENVIRONMENT:-production}
app.baseURL = '${APP_BASE_URL:-http://localhost/}'

database.default.hostname = ${DB_HOSTNAME:-localhost}
database.default.database = ${DB_DATABASE:-defaultdb}
database.default.username = ${DB_USERNAME:-root}
database.default.password = ${DB_PASSWORD}
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = ${DB_PORT:-3306}
database.default.DBDebug = false
database.default.encrypt = true
ENVFILE

exec php -S 0.0.0.0:80 -t public public/index.php
