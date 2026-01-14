# Dockerfile for Laravel 12 with FrankenPHP/Octane
# Production-ready configuration

FROM dunglas/frankenphp:1-php8.4-alpine AS base

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    icu-dev \
    postgresql-dev \
    postgresql-client \
    oniguruma-dev \
    linux-headers \
    nodejs \
    npm

# Install PHP extensions
RUN install-php-extensions \
    pcntl \
    pdo_pgsql \
    pgsql \
    gd \
    zip \
    intl \
    mbstring \
    exif \
    bcmath \
    opcache \
    redis

# Set working directory
WORKDIR /app

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure PHP for production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Create custom PHP config
RUN echo "memory_limit=512M" >> "$PHP_INI_DIR/conf.d/custom.ini" && \
    echo "upload_max_filesize=64M" >> "$PHP_INI_DIR/conf.d/custom.ini" && \
    echo "post_max_size=64M" >> "$PHP_INI_DIR/conf.d/custom.ini" && \
    echo "max_execution_time=300" >> "$PHP_INI_DIR/conf.d/custom.ini" && \
    echo "opcache.enable=1" >> "$PHP_INI_DIR/conf.d/custom.ini" && \
    echo "opcache.memory_consumption=256" >> "$PHP_INI_DIR/conf.d/custom.ini" && \
    echo "opcache.interned_strings_buffer=16" >> "$PHP_INI_DIR/conf.d/custom.ini" && \
    echo "opcache.max_accelerated_files=20000" >> "$PHP_INI_DIR/conf.d/custom.ini" && \
    echo "opcache.validate_timestamps=0" >> "$PHP_INI_DIR/conf.d/custom.ini" && \
    echo "opcache.save_comments=1" >> "$PHP_INI_DIR/conf.d/custom.ini" && \
    echo "opcache.jit=1255" >> "$PHP_INI_DIR/conf.d/custom.ini" && \
    echo "opcache.jit_buffer_size=256M" >> "$PHP_INI_DIR/conf.d/custom.ini"

# ============================================
# Development stage
# ============================================
FROM base AS development

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install all dependencies (including dev)
RUN composer install --no-scripts --no-autoloader

# Copy package.json for npm
COPY package.json package-lock.json* ./

# Install npm dependencies
RUN npm install

# Copy application files
COPY . .

# Generate autoload files
RUN composer dump-autoload --optimize

# Build frontend assets
RUN npm run build

# Copy and set up entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache

EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# ============================================
# Production stage
# ============================================
FROM base AS production

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install production dependencies only
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy package.json for npm
COPY package.json ./

# Install npm dependencies and build assets
RUN npm install

# Copy application files
COPY . .

# Generate optimized autoload files
RUN composer dump-autoload --optimize --classmap-authoritative

# Build frontend assets
RUN npm run build

# Remove node_modules after build to reduce image size
RUN rm -rf node_modules

# Copy and set up entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Pre-optimize Laravel (some will be re-run at startup)
RUN php artisan package:discover --ansi

# Publish Filament assets during build
RUN php artisan filament:assets

# Set permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache

EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

USER www-data

EXPOSE 8000

CMD ["php", "artisan", "octane:frankenphp", "--host=0.0.0.0", "--port=8000"]
