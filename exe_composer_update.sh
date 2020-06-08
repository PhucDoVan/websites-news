#!/bin/sh
docker-compose exec php-server bash -c "php composer.phar update -o"
