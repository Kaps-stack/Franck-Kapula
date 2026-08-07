FROM php:8.4-cli

WORKDIR /var/www/html

# Dépendances système + extensions PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libsqlite3-dev \
    libonig-dev \
    libicu-dev \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        zip \
        mbstring \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Application
COPY . .

# Dépendances PHP
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Permissions Laravel
RUN chmod -R 775 storage bootstrap/cache

# Créer les dossiers nécessaires
RUN mkdir -p database storage/app/public

# Lien storage
RUN php artisan storage:link || true

EXPOSE 8000

CMD php artisan config:clear && \
    php artisan migrate --force && \
    php artisan optimize:clear && \
    php artisan serve --host=0.0.0.0 --port=${PORT}
