#!/usr/bin/env bash
set -e

# Clear and cache configurations
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations (and seed if the DB is empty or explicitly requested).
# For SQLite, the file is recreated on fresh deployments.
php artisan migrate --force --seed

# Start apache in the foreground
exec apache2-foreground
