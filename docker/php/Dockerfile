FROM ghcr.io/roadrunner-server/roadrunner:2025.1.13 AS roadrunner
FROM php:8.5-cli AS base

ARG UID=1000
ARG GID=1000

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libpq-dev \
    libonig-dev \
    libssl-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    supervisor

RUN docker-php-ext-install -j$(nproc) \
    pdo_pgsql  \
    pgsql \
    intl \
    zip \
    bcmath \
    sockets

RUN pecl install protobuf && \
    docker-php-ext-enable protobuf

RUN apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/php/config/php.ini $PHP_INI_DIR/php.ini
COPY docker/php/config/supervisord/base.conf /etc/supervisor/conf.d/supervisord.conf

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr
COPY docker/php/config/.rr.yml /usr/local/etc/.rr.yml

COPY docker/php/config/entrypoint.sh /entrypoint.sh

RUN if getent group ${GID}; then \
      useradd -m -u ${UID} -g ${GID} -s /bin/bash www; \
    else \
      groupadd -g ${GID} www && \
      useradd -m -u ${UID} -g www -s /bin/bash www; \
    fi

RUN chown -R www:www /var/log && \
    mkdir -p /var/www/html/storage && \
    chown -R www:www /var/www/html/storage && \
    mkdir -p /var/www/html/bootstrap && \
    chown -R www:www /var/www/html/bootstrap && \
    chown -R www:www /entrypoint.sh && \
    chmod u+x /entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]

FROM base AS development

RUN pecl install xdebug-3.5.1 && docker-php-ext-enable xdebug

COPY docker/php/config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY docker/php/config/supervisord/dev.conf /etc/supervisor/conf.d/includes/dev.conf

USER www

FROM base AS production

COPY backend /var/www/html

RUN chmod -R o+w /var/www/html/storage && \
    chown -R www:www /var/www/html/bootstrap

USER www
