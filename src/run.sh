#!/bin/sh

if ! test -f ".env"; then
    cp .env.example .env
fi

composer install

while ! nc -z db 3306; do
    echo 'No db connection... retry..'
    sleep 1
done

php artisan key:generate
php artisan migrate
php artisan serve --host=0.0.0.0 --port=80
