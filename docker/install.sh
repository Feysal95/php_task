#!/bin/bash
./create_env.sh

docker-compose up --build -d
docker exec -ti php-fpm sh -c "composer install"
docker exec -ti php-fpm sh -c "php bin/console doctrine:database:create"
docker exec -ti php-fpm sh -c "php bin/console doctrine:migrations:migrate --no-interaction"
docker exec -ti php-fpm sh -c "php bin/console parseArticles 15"
docker-compose stop