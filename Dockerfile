# Use official PHP with Apache
FROM php:8.2-apache

# Install required Php extensions for Laravel + GD dependencies
RUN apt-get update && apt-get install install -y \ 
    git unzip libpq-dev libzip-dev zip \ 
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freestype \
    && docker-php-ext-install pdo pdo_mysql zip


#Enable Apache mob_rewrite (needed for laravel routes)
RUN a2enmod rewrite

#SET Apache DocumentRoot ot /var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|public|g' /etc/apache2/apache2.conf

#COPY APP code
COPY . /var/www/html/


#Create uploads folder and set permissions
RUN mkdir -p /var/www/html/public/storage/uploads/documents \ 
    && mkdir -p /var/www/html/public/storage/uploads/pictures \ 
    && chown -R www-data:www-data /var/www/html/public/uploads \
    && chmod -R 777 /var/www/html/public/storage

#Set Working dir
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer 

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader
RUN php artisan storage:link

# Install Node + npm
RUN apt-get update && apt-get install -y nodejs npm

#Build frontend assets
RUN npm install && npm run Build

#Fix Laravel storage permissions
RUN chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/bootstrap/cache

#Expose Render's required port
EXPOSE 10000

#start Apache
CMD ["apache2-foreground"]