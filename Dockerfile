# =========================================================
# Etapa 1: compilar los recursos de Vite
# =========================================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

RUN npm run build


# =========================================================
# Etapa 2: aplicación Laravel
# =========================================================
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install \
        zip \
        pdo_pgsql \
        pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

COPY --from=frontend /app/public/build ./public/build

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD ["sh", "-c", "php artisan migrate --force && \
php artisan optimize:clear && \
php artisan db:seed --class=DominioSeeder --force && \
php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
