FROM php:8.2-apache

# 1. Dependencias del sistema + extensiones PHP + python3
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libonig-dev \
    zip \
    unzip \
    curl \
    git \
    python3 \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        zip \
        opcache \
        bcmath \
        mbstring \
    && rm -rf /var/lib/apt/lists/*

# 2. Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# 3. Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# 4. FIX MPM: eliminar symlinks directamente (más confiable que a2dismod)
RUN rm -f /etc/apache2/mods-enabled/mpm_event.conf \
          /etc/apache2/mods-enabled/mpm_event.load \
          /etc/apache2/mods-enabled/mpm_worker.conf \
          /etc/apache2/mods-enabled/mpm_worker.load \
    && a2enmod mpm_prefork rewrite \
    && echo "=== MPM habilitado ===" && ls /etc/apache2/mods-enabled/mpm_*

# 5. Configurar Apache: puerto 10000 + DocumentRoot /public
RUN sed -i 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf \
    && sed -i 's/:80>/:10000>/' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# 6. Habilitar .htaccess
RUN printf '<Directory /var/www/html/public>\n\tOptions Indexes FollowSymLinks\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n' \
    >> /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# 7. Dependencias PHP
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# 8. Assets frontend
COPY package.json ./
RUN npm install
COPY . .
RUN npm run build && rm -rf node_modules

# 9. Autoload final
RUN composer dump-autoload --optimize

# 10. Permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 11. Entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 10000
ENTRYPOINT ["/entrypoint.sh"]