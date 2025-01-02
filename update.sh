#!/bin/bash

php bin/console asset-map:compile
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console cache:clear