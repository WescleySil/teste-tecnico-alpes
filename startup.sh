#!/bin/bash

cp .env.example .env
composer install
php artisan key:generate
php artisan migrate:fresh --seed
supervisord -c /etc/supervisor/conf.d/supervisord.conf &
sleep 5
exec php-fpm
