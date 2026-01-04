FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Install Laravel dependencies (production only)
RUN composer install --no-dev --optimize-autoloader

# Expose port (informational)
EXPOSE 8080

# Start Laravel (NO artisan serve)
CMD php -S 0.0.0.0:$PORT -t public
