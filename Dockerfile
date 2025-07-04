# Use the official PHP 8.2 FPM image as the base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www


# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip \
    git \
    vim \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer globally by copying from the official Composer image
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copy the application code
COPY . /var/www

# Copy the existing .env file from the host to the container
COPY .env.example /var/www/.env

# Copy the custom PHP-FPM configuration file
COPY www.conf /usr/local/etc/php-fpm.d/www.conf


# Set the COMPOSER_ALLOW_SUPERUSER environment variable
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Composer dependencies
RUN composer install && composer dump-autoload

# Set ownership and permissions for the Laravel project
RUN chown -R www-data:www-data /var/www \
    && chown -R www-data:www-data /var/www/storage \
    && chmod -R 777 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

# Generate Laravel application key
RUN php artisan key:generate

# Switch to www-data user
USER www-data

# Start PHP-FPM
CMD php-fpm && php artisan migrate