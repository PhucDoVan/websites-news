#!/bin/sh
docker-compose down
# コンテナを削除
docker ps -a | awk '{print $1}' | xargs docker rm -f
# イメージを削除
docker images | awk '{print $3}' | xargs docker rmi -f
sudo rm -rf ./db/mysql
exit 0
