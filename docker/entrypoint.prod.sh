#!/bin/sh
set -e

echo "============================================"
echo "  Laravel Filament Production Container"
echo "============================================"

# Wait for database
echo "[1/5] Waiting for database..."
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
echo "[2/5] Running migrations..."
php artisan migrate --force

# Create storage link
echo "[3/5] Storage setup..."
php artisan storage:link 2>/dev/null || true

# Publish Filament assets
echo "[4/5] Publishing assets..."
php artisan filament:assets

# Cache for production
echo "[5/5] Caching..."
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
