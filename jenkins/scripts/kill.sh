#!/usr/bin/env sh

echo 'Killing docker container php:7.2-apache'

set -x
docker kill my-apache-php-app
docker rm my-apache-php-app