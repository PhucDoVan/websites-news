#!/bin/sh
BIN=server/vendor/bin/dep
if [[ ! -f ${BIN} ]]; then
  docker run --rm --interactive --tty -v $PWD/server:/srv -w /srv composer install -o
fi
cd server
./vendor/bin/dep deploy staging
