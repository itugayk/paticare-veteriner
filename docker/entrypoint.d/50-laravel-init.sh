#!/usr/bin/env sh
set -e

cd /var/www/html

echo "🐾 PatiCare — bootstrapping Laravel..."

# Ensure an app key exists (Coolify should provide APP_KEY; generate as fallback)
if ! grep -q "^APP_KEY=base64:" .env 2>/dev/null && [ -z "${APP_KEY}" ]; then
    php artisan key:generate --force || true
fi

# SQLite store
mkdir -p database
[ -f database/database.sqlite ] || touch database/database.sqlite

# Migrate + seed demo data (seeders are idempotent via updateOrCreate)
php artisan migrate --force --seed || php artisan migrate --force || true

# Public storage symlink for uploaded media
php artisan storage:link || true

# Optimise caches (config/route/view) for production
php artisan optimize || true
php artisan filament:cache-components || true

echo "🐾 PatiCare — ready."
