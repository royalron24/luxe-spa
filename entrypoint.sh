#!/bin/bash
set -e

# Determine correct HTTPS base URL for Railway
if [ -n "${APP_BASE_URL}" ]; then
    BASE_URL="${APP_BASE_URL}"
elif [ -n "${RAILWAY_PUBLIC_DOMAIN}" ]; then
    BASE_URL="https://${RAILWAY_PUBLIC_DOMAIN}/"
else
    BASE_URL=""
fi

# Generate .env file from environment variables at container start
cat > /var/www/html/.env << ENVFILE
CI_ENVIRONMENT = ${CI_ENVIRONMENT:-production}
app.baseURL = '${BASE_URL}'

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
