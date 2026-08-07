# ==============================
# Stage 1 : Frontend
# ==============================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./

RUN npm ci

COPY resources ./resources
COPY vite.config.js ./

RUN npm run build


# ==============================
# Stage 2 : Laravel
# ==============================
FROM php:8.4-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    libicu-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip \
    mbstring \
    intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

COPY . .

# Assets Filament
RUN php artisan filament:assets

# Assets Vite
COPY --from=frontend /app/public/build ./public/build

RUN chmod -R 777 storage bootstrap/cache

RUN php artisan storage:link || true

EXPOSE 8000

CMD php artisan config:clear \
    && php artisan migrate --force \
    && php artisan optimize:clear \
    && php artisan serve --host=0.0.0.0 --port=$PORT
