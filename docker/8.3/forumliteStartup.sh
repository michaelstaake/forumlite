#!/usr/bin/env bash

sleep 5
echo "Welcome to Forumlite!"
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link