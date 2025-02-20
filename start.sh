#!/bin/bash

# Iniciar PHP-FPM
php-fpm -D

# Iniciar Nginx
nginx -g "daemon off;"
