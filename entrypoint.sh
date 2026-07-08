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

# Railway injects PORT; default to 80 if not set
APP_PORT=${PORT:-80}
sed -i "s/listen 80 default_server/listen ${APP_PORT} default_server/g" /etc/nginx/sites-available/default

exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
