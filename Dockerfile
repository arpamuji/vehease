# ==========================================
# STAGE 1: Frontend Build (Node.js & NPM)
# ==========================================
# Kita pakai Node LTS (v20) yang paling stabil
FROM node:20-alpine AS frontend
WORKDIR /app

# Copy package.json & lockfile (jika ada)
COPY package*.json ./

# Install dependency (Pakai npm install biar toleran kalau lockfile beda versi)
RUN npm install

# Copy seluruh source code
COPY . .

# Build Vite (Outputnya ada di /app/public/build)
RUN npm run build

# ==========================================
# STAGE 2: Backend Build (Composer)
# ==========================================
FROM composer:2 AS composer_build
WORKDIR /app
COPY composer.json composer.lock ./

# Install vendor PHP tanpa dev-dependency (Optimized)
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs --no-scripts

# ==========================================
# STAGE 3: Final Image (PHP 8.4 FPM)
# ==========================================
FROM php:8.4-fpm

WORKDIR /var/www

# 1. Install System Dependencies
# libpq-dev WAJIB untuk PostgreSQL
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    supervisor \
    libpq-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Install PHP Extensions
# Pastikan pdo_pgsql terinstall untuk koneksi database Postgres kamu
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

# 3. Copy Vendor dari Stage Composer
COPY --from=composer_build /app/vendor /var/www/vendor

# 4. Copy Asset Frontend dari Stage Node.js
COPY --from=frontend /app/public/build /var/www/public/build

# 5. Copy Sisa Source Code Aplikasi
COPY . /var/www

# 6. Copy Config Supervisor
# Pastikan file ini ada di folder project kamu: docker/supervisor/supervisord.conf
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# 7. Set Permissions (Agar Laravel bisa tulis log & upload)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Expose Port
EXPOSE 9000

# Jalankan Supervisor (menghandle PHP-FPM & Queue Worker)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]