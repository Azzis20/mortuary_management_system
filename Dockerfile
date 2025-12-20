# Use official PHP with Apache
FROM php:8.2-apache

# Install required PHP extensions for Laravel + GD dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Enable Apache mod_rewrite (needed for Laravel routes)
RUN a2enmod rewrite

# SET Apache DocumentRoot to /var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|Directory /var/www/|Directory /var/www/html/public|g' /etc/apache2/apache2.conf

# Set AllowOverride All for Laravel routes to work
RUN sed -i '/<Directory \/var\/www\/html\/public>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# COPY APP code
COPY . /var/www/html/

# Set Working dir
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer 

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Create storage directories and set permissions
RUN mkdir -p /var/www/html/storage/app/public/documents \
    && mkdir -p /var/www/html/storage/app/public/profiles \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/public/storage

# Set proper ownership before creating symbolic link
RUN chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage

# Create symbolic link for storage (ignore if already exists)
RUN php artisan storage:link || true

# Install Node + npm
RUN apt-get update && apt-get install -y nodejs npm

# Build frontend assets
RUN npm install && npm run build

# Final permission fixes for Laravel
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/public \
    && chmod -R 775 /var/www/html/public

# Expose Render's required port
EXPOSE 10000

# Start Apache with dynamic port configuration
CMD echo "Listen ${PORT:-10000}" > /etc/apache2/ports.conf && \
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT:-10000}>/" /etc/apache2/sites-available/000-default.conf && \
    apache2-foreground
