FROM php:8.4-cli-alpine

# Install system dependencies & SQLite
RUN apk add --no-cache \
    curl \
    git \
    sqlite \
    sqlite-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    libpng-dev \
    icu-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite mbstring zip bcmath gd intl opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create SQLite database and storage permissions
RUN touch database/database.sqlite \
    && chmod -R 777 storage bootstrap/cache database

# Setup environment
ENV PORT=10000
ENV DB_CONNECTION=sqlite
ENV APP_ENV=production
ENV APP_URL=https://bundle-management-system-1.onrender.com
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# Expose Render port
EXPOSE 10000

# Startup script to migrate, seed, cache and serve
CMD php artisan migrate --force --seed \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}