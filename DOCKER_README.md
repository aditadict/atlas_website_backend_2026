# Docker Deployment Guide

## Overview

This Laravel 12 application is configured to run with:
- **FrankenPHP** (Laravel Octane server)
- **Caddy** (Reverse proxy with automatic HTTPS)
- **PostgreSQL 16** (Database)
- **Redis 7** (Cache & Sessions)

## Domain

Production domain: `atlassite-api.atlasdigitalize.com`

## Database Configuration

- **Host**: postgres (internal) / localhost:5439 (external)
- **Port**: 5432 (internal) / 5439 (external)
- **Database**: atlas_website_backend
- **Username**: atlas-db-admin
- **Password**: AtlasDigitaliz3@123

## Quick Start

### Local Development

```bash
# Start all services for local development
docker compose -f docker-compose.local.yml up -d

# View logs
docker compose -f docker-compose.local.yml logs -f

# Stop services
docker compose -f docker-compose.local.yml down
```

Access the application at: http://localhost:8000

### Production Deployment

1. **Generate APP_KEY** (if not already set):
   ```bash
   php artisan key:generate --show
   ```

2. **Update APP_KEY** in docker-compose.yml or use environment variables:
   ```bash
   export APP_KEY=base64:your-generated-key-here
   ```

3. **Deploy**:
   ```bash
   # Build and start all services
   docker compose up -d --build

   # Run migrations (first time or after schema changes)
   docker compose exec app php artisan migrate --force

   # View logs
   docker compose logs -f

   # Check status
   docker compose ps
   ```

## Services

| Service | Container Name | Port (Host:Container) | Description |
|---------|---------------|----------------------|-------------|
| app | atlas-app | 8000 (internal) | Laravel Octane with FrankenPHP |
| postgres | atlas-postgres | 5439:5432 | PostgreSQL Database |
| redis | atlas-redis | - | Redis Cache |
| caddy | atlas-caddy | 80:80, 443:443 | Reverse Proxy with HTTPS |
| queue | atlas-queue | - | Queue Worker |
| scheduler | atlas-scheduler | - | Task Scheduler |

## Common Commands

### Application Management

```bash
# Enter app container
docker compose exec app sh

# Run artisan commands
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear

# Restart Octane (after code changes in production)
docker compose exec app php artisan octane:reload
```

### Database Management

```bash
# Connect to PostgreSQL
docker compose exec postgres psql -U atlas-db-admin -d atlas_website_backend

# Backup database
docker compose exec postgres pg_dump -U atlas-db-admin atlas_website_backend > backup.sql

# Restore database
cat backup.sql | docker compose exec -T postgres psql -U atlas-db-admin -d atlas_website_backend
```

### Logs & Monitoring

```bash
# View all logs
docker compose logs -f

# View specific service logs
docker compose logs -f app
docker compose logs -f postgres
docker compose logs -f caddy

# View Laravel logs
docker compose exec app tail -f storage/logs/laravel.log
```

## SSL Certificates

Caddy automatically obtains and renews SSL certificates from Let's Encrypt. Make sure:

1. Port 80 and 443 are open on your server
2. DNS is properly configured for `atlassite-api.atlasdigitalize.com`
3. The domain points to your server's IP address

## Scaling

To scale the app service:

```bash
docker compose up -d --scale app=3
```

Update the Caddyfile for load balancing when scaling.

## Volumes

| Volume | Purpose |
|--------|---------|
| postgres_data | PostgreSQL data persistence |
| redis_data | Redis data persistence |
| app_storage | Laravel storage files |
| app_logs | Laravel log files |
| caddy_data | Caddy certificates and data |
| caddy_config | Caddy configuration |

## Environment Variables

Key environment variables that can be overridden:

| Variable | Default | Description |
|----------|---------|-------------|
| APP_ENV | production | Application environment |
| APP_DEBUG | false | Debug mode |
| APP_KEY | - | Application encryption key |
| DB_HOST | postgres | Database host |
| DB_PORT | 5432 | Database port |
| DB_DATABASE | atlas_website_backend | Database name |
| DB_USERNAME | atlas-db-admin | Database user |
| DB_PASSWORD | AtlasDigitaliz3@123 | Database password |
| REDIS_HOST | redis | Redis host |
| CACHE_STORE | redis | Cache driver |

## Troubleshooting

### Application not accessible

```bash
# Check if containers are running
docker compose ps

# Check app logs
docker compose logs app

# Check Caddy logs
docker compose logs caddy
```

### Database connection issues

```bash
# Check if PostgreSQL is healthy
docker compose exec postgres pg_isready -U atlas-db-admin

# Check database logs
docker compose logs postgres
```

### SSL certificate issues

```bash
# Check Caddy logs for certificate errors
docker compose logs caddy | grep -i "certificate\|tls\|acme"

# Restart Caddy to retry certificate obtainment
docker compose restart caddy
```

## Security Notes

1. **Change default passwords** before deploying to production
2. **Use Docker secrets** or external secret management for sensitive data
3. **Keep images updated** regularly for security patches
4. **Restrict database access** - PostgreSQL port 5439 should only be accessible from trusted networks
5. **Enable firewall** rules to only allow ports 80, 443, and 22 (SSH) from the internet
