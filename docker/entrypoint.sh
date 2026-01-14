#!/bin/sh
set -e

# =============================================================================
# Laravel Filament Container Entrypoint
# =============================================================================

echo "============================================"
echo "  Laravel Filament Container Starting..."
echo "============================================"

# Wait for database to be ready
echo "[1/8] Waiting for database to be ready..."
MAX_ATTEMPTS=30
ATTEMPT=1

while [ $ATTEMPT -le $MAX_ATTEMPTS ]; do
    if pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME" -d "$DB_DATABASE" > /dev/null 2>&1; then
        echo "      Database is ready!"
        break
    fi
    echo "      Database is unavailable - attempt $ATTEMPT/$MAX_ATTEMPTS"
    sleep 2
    ATTEMPT=$((ATTEMPT + 1))
done

if [ $ATTEMPT -gt $MAX_ATTEMPTS ]; then
    echo "      ERROR: Database failed to start"
    exit 1
fi

# Run migrations
echo "[2/8] Running database migrations..."
php artisan migrate --force
echo "      Migrations completed!"

# Create storage link if not exists
echo "[3/8] Setting up storage..."
if [ ! -L "public/storage" ]; then
    php artisan storage:link
    echo "      Storage link created!"
else
    echo "      Storage link already exists"
fi

# Publish Filament assets
echo "[4/8] Publishing Filament assets..."
php artisan filament:assets
echo "      Filament assets published!"

# Cache icons
echo "[5/8] Caching icons..."
php artisan icons:cache || true
echo "      Icons cached!"

# Clear and cache configs for production
if [ "$APP_ENV" = "production" ]; then
    echo "[6/8] Optimizing for production..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
    echo "      Configuration cached!"

    echo "[7/8] Caching Filament components..."
    php artisan filament:cache-components
    echo "      Filament components cached!"
else
    echo "[6/8] Development mode - skipping config cache"
    echo "[7/8] Development mode - skipping Filament cache"
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
fi

# Start the application
echo "[8/8] Starting application..."
echo ""
echo "============================================"
echo "  Application Ready!"
echo "============================================"
echo ""

# If a command is passed (e.g., from docker-compose), run it
# Otherwise, start the server
if [ $# -gt 0 ]; then
    echo "  Running custom command: $@"
    exec "$@"
else
    echo "  Server: PHP Built-in Server"
    echo "  Host: 0.0.0.0:8000"
    exec php artisan serve --host=0.0.0.0 --port=8000
fi
