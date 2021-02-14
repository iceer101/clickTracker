FROM php:8-fpm

# Set working directory
WORKDIR /var/www

# Install extensions
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install -y netcat git zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Change current user to www
USER www

CMD ["./run.sh"]