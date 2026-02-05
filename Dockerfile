FROM php:7.4-apache


# Disable conflicting MPMs and enable prefork + rewrite
RUN a2dismod mpm_event mpm_worker \
    && a2enmod mpm_prefork rewrite

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Create writable session folder
RUN mkdir -p /var/lib/php/sessions \
    && chmod -R 777 /var/lib/php/sessions

# Copy all PHPRad project files to Apache root
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

# Make uploads folder writable (if your PHPRad uses it)
RUN chmod -R 777 /var/www/html/uploads
