#!/bin/bash

echo "Starting Laravel..."

php artisan config:clear
php artisan cache:clear

php artisan migrate --force || true

php artisan config:cache

exec apache2-foreground