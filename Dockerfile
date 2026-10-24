
# Stage 1: Build frontend assets
FROM node:24-bookworm-slim AS frontend
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build


# Stage 2: Install PHP dependencies
FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --no-scripts

COPY . .
RUN rm -f bootstrap/cache/packages.php bootstrap/cache/services.php \
    && composer dump-autoload --optimize --no-dev


# Stage 3: Production application
FROM php:8.4-apache-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install \
    bcmath \
    intl \
    opcache \
    pdo_mysql \
    zip \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

    RUN apt-get update && apt-get install -y libzip-dev unzip \
    && docker-php-ext-install zip

# Configure Apache to serve Laravel's public directory.
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache

# Create Render startup script.
RUN <<'EOF'
cat > /usr/local/bin/render-start <<'SCRIPT'
#!/bin/sh
set -eu
PORT="${PORT:-10000}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
exec apache2-foreground
SCRIPT
chmod +x /usr/local/bin/render-start
EOF

EXPOSE 10000
CMD ["/usr/local/bin/render-start"]
