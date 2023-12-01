#!/usr/bin/env bash

echo "Welcome to Forumlite..."
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
sail artisan key:generate
sail artisan migrate
sail artisan db:seed
sail artisan storage:link