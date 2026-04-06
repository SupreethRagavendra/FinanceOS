FROM php:8.3-apache

# Use the official PHP extension installer (handles all deps automatically)
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions pdo_sqlite mbstring exif pcntl bcmath gd zip intl opcache

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Update Apache document root to Laravel's public/ folder
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Allow .htaccess overrides
RUN echo '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>' \
    >> /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy app source
COPY . .

# Bootstrap env + directories + SQLite file before composer runs
RUN mkdir -p database storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache \
    && touch database/database.sqlite \
    && cp .env.example .env

# Install dependencies (unlimited memory, bypass platform lock mismatch)
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
RUN php -d memory_limit=-1 /usr/bin/composer install \
    --optimize-autoloader \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --ignore-platform-reqs

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

EXPOSE 80

RUN chmod +x docker-start.sh
CMD ["./docker-start.sh"]
