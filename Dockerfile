# Use the official PHP image as base
FROM php:8.0-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www/html

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application code
COPY . .

# Run Composer scripts
RUN composer dump-autoload --optimize

# Expose port 8000 to the outside world
EXPOSE 8000

# Command to run the application
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
