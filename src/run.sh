#!/bin/sh

while ! nc -z db 3306; do
    echo 'No db connection... retry..'
    sleep 1
done

php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=80
