**Запуск**   <br>

Установить node;
>npm install;

Скомпилировать

>npm run watch

Запуск приложения
cd laradock <br>
> docker-compose up -d nginx mysql workspace phpmyadmin


http://localhost/

**PhpMyAdmin** <br>
http://127.0.0.1:8081/index.php

Сервер: mysql
Пользователь: default
Пароль: secret

Запуск контейнера с башем

>docker-compose exec workspace bash

Запуск миграций

>php artisan migrate

**Показать все обьявления:** 

>php artisan ads-show-all

**Одно обьявление:** 
>php artisan ads-show :id


**Запуск очередей:**
php artisan queue:listen

Докуметация по API
https://documenter.getpostman.com/view/6472994/TVK5eMr8