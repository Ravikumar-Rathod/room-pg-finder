FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip nodejs npm \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies
RUN npm install

# Build frontend (IMPORTANT FIX)
RUN npm run build

# Fix permissions
RUN chmod -R 775 storage bootstrap/cache

# Clear cache
RUN php artisan config:clear

# Expose dynamic port
EXPOSE 10000

# Start Laravel
CMD php -S 0.0.0.0:$PORT -t public