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

# Resolve DB credentials:
#   Priority 1 – explicit DB_* vars (user-defined overrides)
#   Priority 2 – Railway MySQL plugin vars (MYSQLHOST / MYSQLDATABASE / …)
#   Priority 3 – safe defaults for local/dev
_DB_HOST="${DB_HOSTNAME:-${MYSQLHOST:-localhost}}"
_DB_NAME="${DB_DATABASE:-${MYSQLDATABASE:-${MYSQL_DATABASE:-railway}}}"
_DB_USER="${DB_USERNAME:-${MYSQLUSER:-${MYSQL_USER:-root}}}"
_DB_PASS="${DB_PASSWORD:-${MYSQLPASSWORD:-${MYSQL_PASSWORD:-}}}"
_DB_PORT="${DB_PORT:-${MYSQLPORT:-${MYSQL_PORT:-3306}}}"

# Generate .env file from environment variables at container start
cat > /var/www/html/.env << ENVFILE
CI_ENVIRONMENT = ${CI_ENVIRONMENT:-production}
app.baseURL = '${BASE_URL}'
app.indexPage = ''

database.default.hostname = ${_DB_HOST}
database.default.database = ${_DB_NAME}
database.default.username = ${_DB_USER}
database.default.password = ${_DB_PASS}
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = ${_DB_PORT}
database.default.DBDebug = false
database.default.encrypt = false
ENVFILE

# Railway injects PORT; default to 80 if not set
APP_PORT=${PORT:-80}
sed -i "s/listen 80 default_server/listen ${APP_PORT} default_server/g" /etc/nginx/sites-available/default

exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
