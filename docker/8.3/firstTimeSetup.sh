#!/usr/bin/env bash

TARGET_FILE="/initialized.txt"

sleep 5
echo "Checking for first time setup..."
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link