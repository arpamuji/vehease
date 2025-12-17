#!/bin/bash

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}🚀 Starting VehEase Deployment...${NC}"

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${YELLOW}⚠️  .env file not found. Creating from .env.example...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✓ .env file created. Please update it with your configuration.${NC}"
    exit 1
fi

# Pull latest changes
echo -e "${YELLOW}📥 Pulling latest changes...${NC}"
git pull origin deploy/staging

# Build and start containers
echo -e "${YELLOW}🔨 Building Docker containers...${NC}"
docker-compose down
docker-compose build --no-cache
docker-compose up -d

# Wait for database to be ready
echo -e "${YELLOW}⏳ Waiting for database...${NC}"
sleep 10

# Install dependencies
echo -e "${YELLOW}📦 Installing dependencies...${NC}"
docker-compose exec app composer install --optimize-autoloader --no-dev
docker-compose exec app bun install
docker-compose exec app bun run build

# Run migrations
echo -e "${YELLOW}🗄️  Running database migrations...${NC}"
docker-compose exec app php artisan migrate --force

# Seed database (optional, comment out if not needed)
# echo -e "${YELLOW}🌱 Seeding database...${NC}"
# docker-compose exec app php artisan db:seed --force

# Clear and cache config
echo -e "${YELLOW}🔧 Optimizing application...${NC}"
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Set permissions
echo -e "${YELLOW}🔐 Setting permissions...${NC}"
docker-compose exec app chown -R www-data:www-data /var/www/storage
docker-compose exec app chown -R www-data:www-data /var/www/bootstrap/cache

echo -e "${GREEN}✅ Deployment completed successfully!${NC}"
echo -e "${GREEN}🌐 Application is running on port ${APP_PORT:-8000}${NC}"
