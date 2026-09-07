# =============================================================================
# Sena Studio — Docker image (déploiement Railway / conteneurs)
#
#   Stage build  : PHP 8.3 (Debian/glibc), composer, dépendances vendor PHP.
#   Stage assets : Node 22, npm ci + build Vite — consomme le vendor PHP (CSS
#                  Flux/Filament importé dans app.css) ramené depuis `build`.
#   Stage runtime: PHP 8.3 CLI minimal → `php artisan serve` sur $PORT
#                  (migrations, lien de stockage et caches via entrypoint).
# =============================================================================

# ---------------------- Dépendances PHP / Composer -------------------------
FROM php:8.3-cli-bookworm AS build

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        zip \
        curl \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        libpq-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        pgsql \
        mbstring \
        intl \
        zip \
        gd \
        exif \
    && rm -rf /var/lib/apt/lists/* \
    && curl -sS https://getcomposer.org/installer \
        | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Cache de couches : dépendances d'abord (Lockfile stable)
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-scripts \
        --no-interaction \
        --prefer-dist \
        --no-progress

# Source complète + autoload + discovery des packages
COPY . .
RUN composer dump-autoload --no-dev --optimize --classmap-authoritative \
    && php artisan package:discover --ansi || true

# ------------------------------- Assets Vite -------------------------------
FROM node:22-bookworm-slim AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
# Vendor PHP nécessaire au build des assets (import Flux + @source Filament)
COPY --from=build /app/vendor /app/vendor
RUN npm run build

# --------------------------------- Runtime --------------------------------
FROM php:8.3-cli-bookworm AS runtime

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        ca-certificates \
        tzdata \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        libpq-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        pgsql \
        mbstring \
        intl \
        zip \
        gd \
        exif \
    && rm -rf /var/lib/apt/lists/*

ENV PHP_CLI_SERVER_WORKERS=1
ENV TZ=UTC
ENV PORT=8080

WORKDIR /app

COPY --from=build /app /app
COPY --from=assets /app/public/build /app/public/build
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && mkdir -p /app/storage/framework/{sessions,views,cache} \
    && chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 8080

HEALTHCHECK --interval=15s --timeout=3s --start-period=60s --retries=3 \
    CMD curl -fsS "http://127.0.0.1:${PORT:-8080}/up" >/dev/null 2>&1 || exit 1

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["sh", "-c", "exec php artisan serve --host=0.0.0.0 --port=\"${PORT:-8080}\""]