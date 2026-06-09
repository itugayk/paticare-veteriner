# syntax=docker/dockerfile:1

# ---------------------------------------------------------------------------
# Stage 1 — Build front-end assets with Vite
# ---------------------------------------------------------------------------
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm ci
COPY resources ./resources
COPY public ./public
RUN npm run build

# ---------------------------------------------------------------------------
# Stage 2 — PHP application (nginx + php-fpm, listens on :8080)
# ---------------------------------------------------------------------------
FROM serversideup/php:8.3-fpm-nginx AS app

ENV PHP_OPCACHE_ENABLE=1 \
    SSL_MODE=off \
    AUTORUN_ENABLED=false

USER root
WORKDIR /var/www/html

# Filament needs ext-intl; ensure sqlite/gd are present too
RUN install-php-extensions intl pdo_sqlite gd

# Install PHP/composer dependencies (cached on lockfile change)
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction --no-progress

# Application source + compiled assets
COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --optimize --no-dev --classmap-authoritative \
 && cp -n .env.example .env || true \
 && mkdir -p database storage/framework/{cache,sessions,views} bootstrap/cache \
 && touch database/database.sqlite \
 && chown -R www-data:www-data /var/www/html \
 && chmod -R ug+rw storage bootstrap/cache database

# Boot hooks (migrate, seed, optimize) — run by serversideup init before the server
COPY docker/entrypoint.d/ /etc/entrypoint.d/
RUN chmod +x /etc/entrypoint.d/*.sh

USER www-data
