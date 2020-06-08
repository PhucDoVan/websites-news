#!/bin/sh
docker-compose exec php-server bash -c 'php artisan optimize:clear'
