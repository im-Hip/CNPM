FROM php:8.2-fpm

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    nginx

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Copy nginx config
COPY nginx.conf /etc/nginx/sites-available/default

# Expose port
EXPOSE 8080

# Start command - migrations chạy TỰ ĐỘNG
CMD php artisan migrate --force && \
    php artisan storage:link && \
    php artisan config:cache && \
    php artisan route:cache && \
    service nginx start && \
    php-fpm
