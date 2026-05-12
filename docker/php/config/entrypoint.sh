#!/bin/bash

composer install --optimize-autoloader --no-interaction --no-progress

php artisan migrate --force
php artisan storage:link
php artisan optimize

rr serve -c /usr/local/etc/.rr.yml -w .
