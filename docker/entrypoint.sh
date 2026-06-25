#!/bin/sh
set -e

# Render injects $PORT at runtime; default to 8080 locally.
PORT="${PORT:-8080}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:8080>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Ensure the SQLite database file exists and is writable
mkdir -p /var/www/html/database
[ -f /var/www/html/database/database.sqlite ] || touch /var/www/html/database/database.sqlite
chown -R www-data:www-data /var/www/html/database

# Apply schema, then seed demo data once per fresh database
php artisan migrate --force
if [ ! -f /var/www/html/database/.seeded ]; then
    php artisan db:seed --force && touch /var/www/html/database/.seeded
fi
php artisan storage:link --force 2>/dev/null || true

exec apache2-foreground
