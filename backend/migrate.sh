#!/bin/bash

php artisan doctrine:migrations:migrate
php artisan db:seed
php artisan passport:install --force
