#!/usr/bin/env bash
set -e

# Write the APP_KEY from Render's env variable into the .env file
# (The .env in the image was copied from .env.example without a real key)
if [ -n "$APP_KEY" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
fi

# Write APP_URL if set by Render
if [ -n "$APP_URL" ]; then
    sed -i "s|^APP_URL=.*|APP_URL=${APP_URL}|" .env
fi

# Write APP_ENV
if [ -n "$APP_ENV" ]; then
    sed -i "s|^APP_ENV=.*|APP_ENV=${APP_ENV}|" .env
fi

# Write APP_DEBUG
if [ -n "$APP_DEBUG" ]; then
    sed -i "s|^APP_DEBUG=.*|APP_DEBUG=${APP_DEBUG}|" .env
fi

# Ensure storage dirs exist after container restarts
mkdir -p database storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
touch database/database.sqlite
chown -R www-data:www-data storage bootstrap/cache database

# Clear config cache and rebuild
php artisan package:discover --ansi
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations and seed
php artisan migrate --force --seed

# Start Apache
exec apache2-foreground
