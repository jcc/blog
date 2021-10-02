#!/bin/bash

# run migration and app
php artisan blog:install
php artisan serve --host 0.0.0.0
