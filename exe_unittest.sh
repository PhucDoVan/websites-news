#!/bin/sh
docker-compose exec php-fpm bash -c "php /srv/vendor/bin/phpunit --testdox --exclude-group skipped"
