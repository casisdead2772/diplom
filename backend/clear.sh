#!/bin/bash
php artisan config:clear
php artisan config:cache
php artisan cache:clear
php artisan route:cache
php artisan view:clear

php artisan config:cache

php artisan doctrine:clear:metadata:cache
php artisan doctrine:clear:query:cache
php artisan doctrine:clear:result:cache
php artisan doctrine:generate:proxies
