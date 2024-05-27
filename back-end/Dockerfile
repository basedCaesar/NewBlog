# # Use the official PHP image with Apache
# FROM php:8.2-apache

# # Set working directory
# WORKDIR /var/www/html

# # Install dependencies
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     zip \
#     unzip \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install gd \
#     && docker-php-ext-install pdo pdo_mysql

# # Enable Apache mod_rewrite
# RUN a2enmod rewrite

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Copy existing application directory contents
# COPY . /var/www/html

# # Install Laravel dependencies
# RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-autoloader

# # Generate optimized autoload files
# RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize

# # Set permissions for Laravel
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Expose port 80
# EXPOSE 8000


# # Use the official PHP image with Apache
# FROM php:8.2-apache

# # Set working directory
# WORKDIR /var/www/html

# # Install dependencies
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     zip \
#     unzip \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install gd \
#     && docker-php-ext-install pdo pdo_mysql

# # Enable Apache mod_rewrite
# RUN a2enmod rewrite

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Copy existing application directory contents
# COPY . /var/www/html

# # Install Laravel dependencies
# RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-autoloader

# # Generate optimized autoload files
# RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize

# # Set permissions for Laravel
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Expose port 8000
# EXPOSE 8000

# Use the official PHP image with Apache
# FROM php:8.2-apache

# # Set working directory
# WORKDIR /var/www/html

# # Install dependencies
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     zip \
#     unzip \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install gd \
#     && docker-php-ext-install pdo pdo_mysql

# # Enable Apache mod_rewrite
# RUN a2enmod rewrite

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Copy existing application directory contents
# COPY . /var/www/html

# # Install Laravel dependencies
# RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-autoloader

# # Generate optimized autoload files
# RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize

# # Set permissions for Laravel
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Expose port 80
# EXPOSE 80

# FROM php:8.2-apache

# # Set working directory
# WORKDIR /var/www/html

# # Install dependencies
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     zip \
#     unzip \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install gd \
#     && docker-php-ext-install pdo pdo_mysql

# # Enable Apache mod_rewrite
# RUN a2enmod rewrite

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Copy existing application directory contents
# COPY . /var/www/html

# # Install Laravel dependencies
# RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-autoloader

# # Generate optimized autoload files
# RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize

# # Set permissions for Laravel
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Expose port 8000
# EXPOSE 80

FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www/html

# Install Laravel dependencies
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-autoloader

# Generate optimized autoload files
RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Update Apache configuration
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Add Directory directive to Apache configuration
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
