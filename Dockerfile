FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions (IMPORTANT)
RUN chmod -R 775 storage bootstrap/cache

# Generate app key (safe fallback)
RUN php artisan key:generate || true

# Clear and cache configs (IMPORTANT)
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan route:clear
RUN php artisan view:clear

# Run database migrations (VERY IMPORTANT)
RUN php artisan migrate --force || true

# Expose port (Render uses dynamic port)
EXPOSE 10000

# Start Laravel server
CMD php -S 0.0.0.0:$PORT -t public