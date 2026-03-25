FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip nodejs npm \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy project
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Node build
RUN npm install
RUN npm run build

# Permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 10000

# ✅ FIXED START COMMAND
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan migrate --force && \
    php -S 0.0.0.0:$PORT -t public