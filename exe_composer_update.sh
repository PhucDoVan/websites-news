#!/bin/sh
docker-compose exec php-fpm bash -c "php composer.phar update -o"
