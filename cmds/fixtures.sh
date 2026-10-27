#! /bin/bash
#create datafixtures

rm -rf var/cache var/log

php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create

# php bin/console make:migration
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction