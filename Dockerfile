# ── Stage 1: Node asset builder ──────────────────────────────────────────────
FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json ./
RUN npm install

COPY . .
RUN npm run build

# ── Stage 2: PHP-FPM runtime ─────────────────────────────────────────────────
FROM php:8.2-fpm-alpine

# System dependencies + PHP extensions
RUN apk add --no-cache \
        bash \
        curl \
        git \
        unzip \
        libpq-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        libzip-dev \
        oniguruma-dev \
        nginx \
        supervisor \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        zip \
        opcache \
        bcmath \
        mbstring

# Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Application source
COPY . .

# Compiled assets from Stage 1
COPY --from=assets /app/public/build ./public/build

# Finalise autoload
RUN composer dump-autoload --optimize

# Permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Nginx config
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# Supervisor config
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 10000

ENTRYPOINT ["/entrypoint.sh"]
