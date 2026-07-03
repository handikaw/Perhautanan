FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    nodejs \
    npm

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_pgsql pgsql pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm ci --include=dev && npm run build && rm -rf node_modules

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

RUN php artisan config:clear && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
