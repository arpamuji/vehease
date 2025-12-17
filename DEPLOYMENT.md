# VehEase Docker Deployment

This document provides instructions for deploying VehEase using Docker on a VPS.

## Prerequisites

- VPS with Ubuntu 20.04+ or similar Linux distribution
- Docker and Docker Compose installed
- Domain name pointed to your VPS IP (optional)
- SSH access to your VPS

## Installation Steps

### 1. Install Docker on VPS

```bash
# Update package index
sudo apt update

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Add your user to docker group (to run docker without sudo)
sudo usermod -aG docker $USER

# Log out and back in for group changes to take effect
```

### 2. Clone Repository on VPS

```bash
# Clone the repository
git clone https://github.com/arpamuji/vehease.git
cd vehease

# Checkout deployment branch
git checkout deploy/staging
```

### 3. Configure Environment

```bash
# Copy production environment file
cp .env.production .env

# Edit environment variables
nano .env
```

Update these important variables:
- `APP_URL` - Your domain or IP address
- `APP_KEY` - Generate with: `docker-compose run --rm app php artisan key:generate --show`
- `DB_PASSWORD` - Strong database password
- `APP_PORT` - Port for the application (default: 8000)

### 4. Deploy Application

```bash
# Make deploy script executable
chmod +x deploy.sh

# Run deployment
./deploy.sh
```

### 5. Generate Application Key (First Time Only)

```bash
docker-compose exec app php artisan key:generate
```

### 6. Access Application

Open your browser and navigate to:
- `http://your-vps-ip:8000`
- Or `http://your-domain.com:8000`

## Management Commands

### Start Containers
```bash
docker-compose up -d
```

### Stop Containers
```bash
docker-compose down
```

### View Logs
```bash
docker-compose logs -f app
```

### Run Artisan Commands
```bash
docker-compose exec app php artisan [command]
```

### Run Migrations
```bash
docker-compose exec app php artisan migrate
```

### Seed Database
```bash
docker-compose exec app php artisan db:seed
```

### Access Container Shell
```bash
docker-compose exec app bash
```

### Rebuild Containers
```bash
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

## Production Optimizations

### 1. Set Up Nginx Reverse Proxy (Recommended)

Install Nginx on host machine:
```bash
sudo apt install nginx
```

Create Nginx configuration:
```bash
sudo nano /etc/nginx/sites-available/vehease
```

Add configuration:
```nginx
server {
    listen 80;
    server_name your-domain.com;

    location / {
        proxy_pass http://localhost:8000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/vehease /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 2. Set Up SSL with Certbot

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d your-domain.com
```

### 3. Set Up Firewall

```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

## Monitoring

### Check Container Status
```bash
docker-compose ps
```

### Check Resource Usage
```bash
docker stats
```

### View Application Logs
```bash
docker-compose logs -f app
tail -f storage/logs/laravel.log
```

## Backup

### Database Backup
```bash
docker-compose exec db mysqldump -u vehease -p vehease > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Restore Database
```bash
docker-compose exec -T db mysql -u vehease -p vehease < backup.sql
```

## Troubleshooting

### Clear All Caches
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Permission Issues
```bash
docker-compose exec app chown -R www-data:www-data /var/www/storage
docker-compose exec app chown -R www-data:www-data /var/www/bootstrap/cache
docker-compose exec app chmod -R 775 /var/www/storage
docker-compose exec app chmod -R 775 /var/www/bootstrap/cache
```

### Container Won't Start
```bash
# Check logs
docker-compose logs app

# Rebuild from scratch
docker-compose down -v
docker-compose build --no-cache
docker-compose up -d
```

## Update Deployment

```bash
# Pull latest changes
git pull origin deploy/staging

# Run deployment script
./deploy.sh
```

## Security Recommendations

1. Change default database password
2. Use strong `APP_KEY`
3. Set `APP_DEBUG=false` in production
4. Use HTTPS/SSL certificates
5. Regular backups
6. Keep Docker images updated
7. Monitor logs regularly
8. Use firewall rules
9. Implement rate limiting
10. Regular security updates

## Support

For issues or questions, contact the development team or check the main README.md file.
