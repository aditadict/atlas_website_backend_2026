#!/bin/sh
set -e

echo "============================================"
echo "  Laravel Filament Production Container"
echo "============================================"

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "[0/6] Generating APP_KEY..."
    export APP_KEY="base64:$(head -c 32 /dev/urandom | base64)"
    echo "APP_KEY=$APP_KEY" > /app/.env
    echo "      APP_KEY generated: $APP_KEY"
fi

# Wait for database
echo "[1/6] Waiting for database..."
MAX_ATTEMPTS=30
ATTEMPT=1
while [ $ATTEMPT -le $MAX_ATTEMPTS ]; do
    if pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME" -d "$DB_DATABASE" > /dev/null 2>&1; then
        echo "      Database ready!"
        break
    fi
    echo "      Waiting... ($ATTEMPT/$MAX_ATTEMPTS)"
    sleep 2
    ATTEMPT=$((ATTEMPT + 1))
done

if [ $ATTEMPT -gt $MAX_ATTEMPTS ]; then
    echo "ERROR: Database timeout"
    exit 1
fi

# Run migrations
echo "[2/6] Running migrations..."
php artisan migrate --force

# Create storage link
echo "[3/6] Storage setup..."
php artisan storage:link 2>/dev/null || true

# Publish Filament assets
echo "[4/6] Publishing assets..."
php artisan filament:assets

# Cache for production
echo "[5/6] Caching..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan icons:cache || true
php artisan filament:cache-components || true

echo ""
echo "============================================"
echo "  Starting Server: $@"
echo "============================================"

exec "$@"
