## Tests
php vendor/bin/phpunit

## Start
php artisan key:generate
php artisan migrate
php artisan create:user

## Work
docker run --name admin.lsuzu.ru \
    --link  work-mysql:db \
    -p 8087:8087  \
    -v '/Users/user/PhpstormProjects:/app' \
    -w '/app/admin.lsuzu.ru' \
    --rm -i -t my/php sh

## Run server
php -S 0.0.0.0:8087 -t public/

## Create database
docker exec -it work-mysql bash
mysql -uroot -p123 isuzu_project

apk --update add

LANG=ru_RU.UTF-8 LANGUAGE=ru_RU.UTF-8 mysql -uroot -p123 isuzu_project < /var/lib/mysql/_dump/query.sql

ENV LC_ALL en_US.UTF-8
ENV LANG en_US.UTF-8

 

CREATE DATABASE IF NOT EXISTS admin_lsuzu_ru;

# напоминание о звонке

# проверка звонков у цифровой телефонии

* * * * * php /php/crm.isuzu.market/artisan schedule:run >> /dev/null 2>&1

// api для определения номера телефона
tests/Unit/GetRegionApiTest.php

tests/Unit/MailTest.php