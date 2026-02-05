FROM php:7.4-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# Install mysqli & pdo_mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files to Apache root
COPY . /var/www/html/

# Fix permissions
RUN chown -R www-data:www-data /var/www/html
