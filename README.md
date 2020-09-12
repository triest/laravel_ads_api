
cd laradock <br>
docker-compose up -d nginx mysql workspace phpmyadmin


http://localhost/

PhpMyAdmin <br>
http://127.0.0.1:8081/index.php

Сервер: mysql
Пользователь: default
Пароль: secret

docker-compose exec workspace bash

Показать все обьявления: 

php artisan ads-show-all

Одно обьявление: 
php artisan ads-show :id


Запуск очередей:
php artisan queue:listen

