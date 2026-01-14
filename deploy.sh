#!/bin/bash
set -e

# =============================================================================
# Laravel Filament Deployment Script
# =============================================================================
# This script handles the complete deployment process for Laravel 12 + Filament v4
# with Docker, PostgreSQL, Redis, and FrankenPHP/Octane
# =============================================================================

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
COMPOSE_FILE="${COMPOSE_FILE:-docker-compose.yml}"
APP_CONTAINER="atlas-app"
DB_CONTAINER="atlas-postgres"

# Functions
log_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

log_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if Docker is running
check_docker() {
    log_info "Checking Docker..."
    if ! docker info > /dev/null 2>&1; then
        log_error "Docker is not running. Please start Docker and try again."
        exit 1
    fi
    log_success "Docker is running"
}

# Check if .env file exists
check_env() {
    log_info "Checking environment configuration..."
    if [ ! -f ".env" ]; then
        if [ -f ".env.docker" ]; then
            log_warning ".env file not found. Copying from .env.docker..."
            cp .env.docker .env
        else
            log_error ".env file not found. Please create one from .env.example"
            exit 1
        fi
    fi
    
    # Check if APP_KEY is set
    if ! grep -q "APP_KEY=base64:" .env; then
        log_warning "APP_KEY not set. Generating..."
        APP_KEY=$(docker run --rm -v "$(pwd)":/app -w /app dunglas/frankenphp:1-php8.3-alpine php artisan key:generate --show 2>/dev/null || php artisan key:generate --show)
        sed -i.bak "s|APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
        rm -f .env.bak
        log_success "APP_KEY generated"
    fi
    log_success "Environment configuration OK"
}

# Build Docker images
build_images() {
    log_info "Building Docker images..."
    docker compose -f "$COMPOSE_FILE" build --no-cache
    log_success "Docker images built successfully"
}

# Start containers
start_containers() {
    log_info "Starting containers..."
    docker compose -f "$COMPOSE_FILE" up -d
    log_success "Containers started"
}

# Wait for database to be ready
wait_for_database() {
    log_info "Waiting for database to be ready..."
    local max_attempts=30
    local attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        if docker compose -f "$COMPOSE_FILE" exec -T postgres pg_isready -U atlas-db-admin -d atlas_website_backend > /dev/null 2>&1; then
            log_success "Database is ready"
            return 0
        fi
        echo -n "."
        sleep 2
        attempt=$((attempt + 1))
    done
    
    log_error "Database failed to start within expected time"
    exit 1
}

# Run database migrations
run_migrations() {
    log_info "Running database migrations..."
    docker compose -f "$COMPOSE_FILE" exec -T app php artisan migrate --force
    log_success "Migrations completed"
}

# Run database seeders (optional)
run_seeders() {
    if [ "$1" == "--seed" ]; then
        log_info "Running database seeders..."
        docker compose -f "$COMPOSE_FILE" exec -T app php artisan db:seed --force
        log_success "Seeders completed"
    fi
}

# Create storage link
create_storage_link() {
    log_info "Creating storage link..."
    docker compose -f "$COMPOSE_FILE" exec -T app php artisan storage:link || true
    log_success "Storage link created"
}

# Optimize Laravel for production
optimize_laravel() {
    log_info "Optimizing Laravel for production..."
    
    docker compose -f "$COMPOSE_FILE" exec -T app php artisan config:cache
    docker compose -f "$COMPOSE_FILE" exec -T app php artisan route:cache
    docker compose -f "$COMPOSE_FILE" exec -T app php artisan view:cache
    docker compose -f "$COMPOSE_FILE" exec -T app php artisan event:cache
    docker compose -f "$COMPOSE_FILE" exec -T app php artisan filament:cache-components
    docker compose -f "$COMPOSE_FILE" exec -T app php artisan icons:cache
    
    log_success "Laravel optimized"
}

# Publish Filament assets
publish_filament_assets() {
    log_info "Publishing Filament assets..."
    docker compose -f "$COMPOSE_FILE" exec -T app php artisan filament:assets
    log_success "Filament assets published"
}

# Clear all caches
clear_caches() {
    log_info "Clearing all caches..."
    docker compose -f "$COMPOSE_FILE" exec -T app php artisan optimize:clear
    log_success "Caches cleared"
}

# Reload Octane
reload_octane() {
    log_info "Reloading Octane..."
    docker compose -f "$COMPOSE_FILE" exec -T app php artisan octane:reload || true
    log_success "Octane reloaded"
}

# Show container status
show_status() {
    log_info "Container status:"
    docker compose -f "$COMPOSE_FILE" ps
}

# Show logs
show_logs() {
    docker compose -f "$COMPOSE_FILE" logs -f "$@"
}

# Stop containers
stop_containers() {
    log_info "Stopping containers..."
    docker compose -f "$COMPOSE_FILE" down
    log_success "Containers stopped"
}

# Full deployment
full_deploy() {
    echo ""
    echo "=========================================="
    echo "  Laravel Filament Deployment"
    echo "  Domain: atlassite-api.atlasdigitalize.com"
    echo "=========================================="
    echo ""
    
    check_docker
    check_env
    build_images
    start_containers
    wait_for_database
    run_migrations
    run_seeders "$1"
    create_storage_link
    publish_filament_assets
    optimize_laravel
    
    echo ""
    log_success "Deployment completed successfully!"
    echo ""
    show_status
    echo ""
    echo "=========================================="
    echo "  Application URLs:"
    echo "  - API: https://atlassite-api.atlasdigitalize.com"
    echo "  - Admin Panel: https://atlassite-api.atlasdigitalize.com/admin"
    echo "  - Database (external): localhost:5439"
    echo "=========================================="
    echo ""
}

# Quick update (no rebuild)
quick_update() {
    log_info "Running quick update..."
    docker compose -f "$COMPOSE_FILE" pull
    start_containers
    wait_for_database
    run_migrations
    clear_caches
    optimize_laravel
    reload_octane
    log_success "Quick update completed"
}

# Rollback (stop and remove)
rollback() {
    log_warning "Rolling back deployment..."
    docker compose -f "$COMPOSE_FILE" down -v
    log_success "Rollback completed"
}

# Backup database
backup_database() {
    local backup_file="backup_$(date +%Y%m%d_%H%M%S).sql"
    log_info "Creating database backup: $backup_file"
    docker compose -f "$COMPOSE_FILE" exec -T postgres pg_dump -U atlas-db-admin atlas_website_backend > "$backup_file"
    log_success "Database backup created: $backup_file"
}

# Restore database
restore_database() {
    if [ -z "$1" ]; then
        log_error "Please provide backup file path"
        exit 1
    fi
    log_info "Restoring database from: $1"
    cat "$1" | docker compose -f "$COMPOSE_FILE" exec -T postgres psql -U atlas-db-admin -d atlas_website_backend
    log_success "Database restored"
}

# Print help
print_help() {
    echo ""
    echo "Laravel Filament Deployment Script"
    echo ""
    echo "Usage: ./deploy.sh [command] [options]"
    echo ""
    echo "Commands:"
    echo "  deploy [--seed]     Full deployment (build, start, migrate, optimize)"
    echo "  update              Quick update without rebuilding images"
    echo "  start               Start containers"
    echo "  stop                Stop containers"
    echo "  restart             Restart containers"
    echo "  rebuild             Rebuild and restart containers"
    echo "  migrate             Run database migrations"
    echo "  seed                Run database seeders"
    echo "  optimize            Optimize Laravel for production"
    echo "  clear               Clear all caches"
    echo "  reload              Reload Octane workers"
    echo "  logs [service]      Show logs (optionally for specific service)"
    echo "  status              Show container status"
    echo "  backup              Backup database"
    echo "  restore <file>      Restore database from backup"
    echo "  rollback            Stop and remove all containers and volumes"
    echo "  shell               Open shell in app container"
    echo "  tinker              Open Laravel Tinker"
    echo "  help                Show this help message"
    echo ""
    echo "Examples:"
    echo "  ./deploy.sh deploy              # Full deployment"
    echo "  ./deploy.sh deploy --seed       # Full deployment with database seeding"
    echo "  ./deploy.sh update              # Quick update"
    echo "  ./deploy.sh logs app            # Show app logs"
    echo "  ./deploy.sh backup              # Create database backup"
    echo ""
}

# Main script
case "${1:-deploy}" in
    deploy)
        full_deploy "$2"
        ;;
    update)
        quick_update
        ;;
    start)
        start_containers
        show_status
        ;;
    stop)
        stop_containers
        ;;
    restart)
        stop_containers
        start_containers
        show_status
        ;;
    rebuild)
        stop_containers
        build_images
        start_containers
        wait_for_database
        run_migrations
        optimize_laravel
        show_status
        ;;
    migrate)
        run_migrations
        ;;
    seed)
        run_seeders "--seed"
        ;;
    optimize)
        optimize_laravel
        ;;
    clear)
        clear_caches
        ;;
    reload)
        reload_octane
        ;;
    logs)
        shift
        show_logs "$@"
        ;;
    status)
        show_status
        ;;
    backup)
        backup_database
        ;;
    restore)
        restore_database "$2"
        ;;
    rollback)
        rollback
        ;;
    shell)
        docker compose -f "$COMPOSE_FILE" exec app sh
        ;;
    tinker)
        docker compose -f "$COMPOSE_FILE" exec app php artisan tinker
        ;;
    help|--help|-h)
        print_help
        ;;
    *)
        log_error "Unknown command: $1"
        print_help
        exit 1
        ;;
esac
