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

# Create a non-root user for Composer
RUN useradd -ms /bin/bash composer

# Set the working directory in the container
WORKDIR /var/www/html

# Copy composer files and install dependencies
COPY composer.json composer.lock ./

# Clean up the vendor directory
RUN rm -rf vendor

# Set Composer environment variables
ENV COMPOSER_HOME=/tmp COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_NO_INTERACTION=1

# Run composer install without optimizations as non-root user
RUN su -c "composer install --no-scripts --no-autoloader" -s /bin/bash composer

# Copy the rest of the application code
COPY . .

# Run Composer scripts
RUN su -c "composer dump-autoload --optimize" -s /bin/bash composer

# Expose port 8000 to the outside world
EXPOSE 8000

# Command to run the application
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
