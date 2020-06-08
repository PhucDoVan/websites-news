#!/bin/sh
docker-compose exec php-fpm bash -c 'php artisan optimize:clear'
