#!/usr/bin/env bash
set -e

# ─── Inject Render environment variables into .env ───────────────────────────
patch_env() {
    local key="$1"
    local val="$2"
    if grep -q "^${key}=" .env; then
        sed -i "s|^${key}=.*|${key}=${val}|" .env
    else
        echo "${key}=${val}" >> .env
    fi
}

[ -n "$APP_KEY" ]   && patch_env "APP_KEY"   "$APP_KEY"
[ -n "$APP_URL" ]   && patch_env "APP_URL"   "$APP_URL"
[ -n "$APP_ENV" ]   && patch_env "APP_ENV"   "$APP_ENV"
[ -n "$APP_DEBUG" ] && patch_env "APP_DEBUG" "$APP_DEBUG"

# ─── Session: use file driver (works on ephemeral SQLite) ────────────────────
patch_env "SESSION_DRIVER"    "file"
patch_env "SESSION_ENCRYPT"   "false"
patch_env "SESSION_SECURE_COOKIE" "false"
patch_env "SESSION_SAME_SITE" "lax"

# ─── Cache: file-based (no Redis/DB needed) ───────────────────────────────────
patch_env "CACHE_STORE"       "file"

# ─── DB: explicit absolute path to SQLite ─────────────────────────────────────
patch_env "DB_CONNECTION"     "sqlite"
patch_env "DB_DATABASE"       "/var/www/html/database/database.sqlite"

# ─── Ensure all required paths exist and have correct ownership ───────────────
mkdir -p database \
         storage/logs \
         storage/framework/sessions \
         storage/framework/views \
         storage/framework/cache \
         bootstrap/cache

touch database/database.sqlite
chmod 777 database/database.sqlite
chmod 777 database

chown -R www-data:www-data storage bootstrap/cache database
chmod -R 775 storage bootstrap/cache

# ─── Laravel bootstrap ────────────────────────────────────────────────────────
php artisan package:discover --ansi 2>/dev/null || true
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations + seed (always fresh on free tier)
php artisan migrate --force --seed

# Start Apache in foreground
exec apache2-foreground
