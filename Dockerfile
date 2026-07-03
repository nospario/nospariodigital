# syntax=docker/dockerfile:1

# ---------------------------------------------------------------------------
# Stage 1 — install PHP dependencies (PHPMailer, for SMTP). Optional but lets
# the mailer use SMTP instead of falling back to mail().
# ---------------------------------------------------------------------------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader

# ---------------------------------------------------------------------------
# Stage 2 — runtime: Apache + PHP 8.3. Apache is used (not the PHP built-in
# server) so the public/.htaccess rewrite/header/cache rules actually apply.
# ---------------------------------------------------------------------------
FROM php:8.3-apache

# curl is used by the HEALTHCHECK below.
RUN apt-get update \
 && apt-get install -y --no-install-recommends curl \
 && rm -rf /var/lib/apt/lists/*

# Apache modules required by public/.htaccess.
RUN a2enmod rewrite headers expires deflate

# Production php.ini + opcache (helps the Lighthouse performance target).
RUN docker-php-ext-install opcache \
 && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Point Apache at /public and allow .htaccess overrides.
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Application code (exclusions in .dockerignore keep prototype files + secrets out).
COPY . /var/www/html
# Composer-installed dependencies from stage 1.
COPY --from=vendor /app/vendor /var/www/html/vendor

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD curl -fsS http://localhost/ >/dev/null || exit 1
