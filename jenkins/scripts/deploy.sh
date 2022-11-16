#!/usr/bin/env sh

echo 'The following deploy file will deloy the php application on php:7.2-apache'

set -x
docker run -d -p 3000:3000 --name my-apache-php-app --volume /var/jenkins_home/workspace/jenkins-php-selenium-test:/var/www/html php:7.2-apache
sleep 1
set +x

echo 'Now...'
echo 'Visit http://172.18.0.2:80/src/index.php to see your PHP application in action.'