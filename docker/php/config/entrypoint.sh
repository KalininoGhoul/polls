#!/bin/bash

composer install --optimize-autoloader --no-interaction --no-progress

php artisan migrate --force
php artisan optimize

supervisord -c /etc/supervisor/conf.d/supervisord.conf
