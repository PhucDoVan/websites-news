#!/bin/sh
docker-compose exec php-server bash -c "php /srv/vendor/bin/phpunit --testdox --exclude-group skipped"
