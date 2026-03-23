FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Fix permissions (IMPORTANT)
RUN chmod -R 775 storage bootstrap/cache

# Generate key & clear cache
RUN php artisan key:generate || true
RUN php artisan config:clear

# Expose port
EXPOSE 10000

# Start Laravel
CMD php -S 0.0.0.0:10000 -t public