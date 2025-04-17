FROM composer:2 AS build

WORKDIR /build

COPY composer.* ./

RUN composer install --no-dev --no-scripts --no-autoloader --ignore-platform-reqs

COPY . .

RUN composer dump-autoload -o

FROM php:8.1.9-fpm-alpine AS production

RUN apk add --no-cache -t .production-deps \
    nginx

RUN set -xe \
    && apk add --no-cache -t .build-deps $PHPIZE_DEPS \
    libpq-dev \
    && pecl install -f apcu-5.1.21 redis-5.3.7 \
    && docker-php-source extract \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install -j$(nproc) pdo_pgsql pgsql pcntl \
    && docker-php-ext-enable apcu redis \
    && docker-php-source delete \
    && pecl clear-cache \
    && rm -rf /tmp/* \
    && apk del --purge .build-deps

COPY docker/etc /etc

ARG S6_OVERLAY_VERSION=v3.1.1.2
RUN S6_OVERLAY_RELEASE=https://github.com/just-containers/s6-overlay/releases/download/${S6_OVERLAY_VERSION} \
    && curl -sSL $S6_OVERLAY_RELEASE/s6-overlay-noarch.tar.xz | tar Jxpf - -C / \
    && curl -sSL $S6_OVERLAY_RELEASE/s6-overlay-x86_64.tar.xz | tar Jxpf - -C /
ENV S6_CMD_WAIT_FOR_SERVICES_MAXTIME=60000

COPY docker/local /usr/local
COPY --from=build --chown=www-data:www-data /build /var/www/foxes-knowledge

EXPOSE 80
WORKDIR /var/www/foxes-knowledge
ENTRYPOINT ["/init"]

FROM production AS development

RUN apk add --no-cache -t .development-deps \
    postgresql14-client

RUN set -xe \
    && apk add --no-cache -t .build-deps $PHPIZE_DEPS \
    && pecl install -f xdebug \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && apk del --purge .build-deps

COPY docker/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=build /usr/bin/composer /usr/local/bin/composer
