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
    && sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/apache2.conf

# Set Working dir
WORKDIR /var/www/html

# COPY APP code
COPY . /var/www/html/

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer 

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node + npm
RUN apt-get update && apt-get install -y nodejs npm

# Build frontend assets
RUN npm install && npm run build

# Create storage directories and set permissions
RUN mkdir -p /var/www/html/public/storage/documents \
    && mkdir -p /var/www/html/public/storage/profiles \
    && mkdir -p /var/www/html/public/uploads \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/public \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Create storage link
RUN php artisan storage:link

# Expose Render's required port
EXPOSE 10000

# Start Apache
CMD ["apache2-foreground"]