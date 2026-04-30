#!/bin/bash

echo "Starting app..."

php artisan config:clear

php artisan cache:clear || true

php artisan migrate --force || true

exec apache2-foreground