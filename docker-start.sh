#!/usr/bin/env bash
set -e

# Inject Render environment variables into .env
if [ -n "$APP_KEY" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
fi

if [ -n "$APP_URL" ]; then
    sed -i "s|^APP_URL=.*|APP_URL=${APP_URL}|" .env
fi

if [ -n "$APP_ENV" ]; then
    sed -i "s|^APP_ENV=.*|APP_ENV=${APP_ENV}|" .env
fi

if [ -n "$APP_DEBUG" ]; then
    sed -i "s|^APP_DEBUG=.*|APP_DEBUG=${APP_DEBUG}|" .env
fi

# Fix 419 CSRF issue: use 'cookie' session driver — works without a persistent DB/filesystem
# On Render's free tier, SQLite is ephemeral so database sessions fail
sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=cookie|" .env

# Fix cookie security for HTTPS on Render
sed -i "s|^SESSION_ENCRYPT=.*|SESSION_ENCRYPT=true|" .env

# Use file-based cache (safe for single-instance deployments)
sed -i "s|^CACHE_STORE=.*|CACHE_STORE=file|" .env

# Ensure required directories exist
mkdir -p database storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
touch database/database.sqlite
chown -R www-data:www-data storage bootstrap/cache database

# Discover packages, clear all caches
php artisan package:discover --ansi
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache

# Run migrations and seed demo data
php artisan migrate --force --seed

# Start Apache
exec apache2-foreground
