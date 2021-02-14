FROM php:8-fpm

# Set working directory
WORKDIR /var/www

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Change current user to www
USER www

#ENTRYPOINT ["ls", "-lah"]
CMD ["./run.sh"]
#CMD ["php-fpm"]
