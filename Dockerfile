FROM php:8.2-fpm

# 1. Sistema + extensiones PHP + python3 + nginx + supervisor
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libjpeg-dev libzip-dev libonig-dev \
    zip unzip curl git python3 nginx supervisor \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip opcache bcmath mbstring \
    && rm -rf /var/lib/apt/lists/*

# 2. Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# 3. Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# 4. Nginx + Supervisor config
COPY docker/default.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN mkdir -p /var/log/supervisor

WORKDIR /var/www/html

# 5. Dependencias PHP
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# 6. Assets frontend
COPY package.json ./
RUN npm install
COPY . .
RUN npm run build && rm -rf node_modules

# 7. Autoload final
RUN composer dump-autoload --optimize

# 8. Permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 10000
ENTRYPOINT ["/entrypoint.sh"]