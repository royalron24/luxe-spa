#!/bin/bash
set -e

# Determine correct HTTPS base URL.
# RAILWAY_PUBLIC_DOMAIN (auto-injected by Railway) always wins.
# APP_BASE_URL can be set as a manual override for non-Railway hosts.
if [ -n "${RAILWAY_PUBLIC_DOMAIN}" ]; then
    BASE_URL="https://${RAILWAY_PUBLIC_DOMAIN}/"
elif [ -n "${RAILWAY_STATIC_URL}" ]; then
    BASE_URL="${RAILWAY_STATIC_URL}/"
elif [ -n "${APP_BASE_URL}" ]; then
    BASE_URL="${APP_BASE_URL}"
else
    # Leave empty so CodeIgniter auto-detects from HTTP_HOST
    BASE_URL=""
fi

# Generate .env file from environment variables at container start
cat > /var/www/html/.env << ENVFILE
CI_ENVIRONMENT = ${CI_ENVIRONMENT:-production}
app.baseURL = '${BASE_URL}'
app.indexPage = ''

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
