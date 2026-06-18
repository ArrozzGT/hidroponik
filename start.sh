#!/bin/bash
# Railway start script for SIPSH Hidroponik

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Storage link
php artisan storage:link --force || true

# Clear caches
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Run migrations
php artisan migrate --force

# Start server
php artisan serve --host=0.0.0.0 --port=$PORT
