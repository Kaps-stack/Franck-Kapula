# ==============================
# Stage 1 : Frontend
# ==============================

FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY resources ./resources
COPY vite.config.js ./

RUN npm run build


# ==============================
# Stage 2 : Laravel
# ==============================

FROM php:8.4-cli

WORKDIR /var/www/html

# ==============================
# Installation des dépendances
# système et extensions PHP
# ==============================

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


# ==============================
# Composer
# ==============================

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# ==============================
# Copier toute l'application
# ==============================

COPY . .


# ==============================
# Installation des dépendances
# Laravel
# ==============================

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader


# ==============================
# Assets Filament
# ==============================

RUN php artisan filament:assets


# ==============================
# Assets Vite
# ==============================

COPY --from=frontend /app/public/build ./public/build


# ==============================
# Permissions Laravel
# ==============================

RUN chmod -R 777 storage bootstrap/cache


# ==============================
# Storage link
# ==============================

RUN php artisan storage:link || true


# ==============================
# Port
# ==============================

EXPOSE 8000


# ==============================
# Démarrage
# ==============================

CMD php artisan config:clear \
    && php artisan migrate --force \
    && php artisan optimize:clear \
    && php artisan serve --host=0.0.0.0 --port=$PORT
