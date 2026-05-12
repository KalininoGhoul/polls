FROM polls-php

USER root

RUN pecl install xdebug-3.5.1 && docker-php-ext-enable xdebug

COPY docker/php/config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

USER www
