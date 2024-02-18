# Полиморфизм
Пример реализации на основе книги ["PHP 8. Наиболее полное руководство (В подлиннике) - 2023 [Котеров Д. В., Симдянов И. В.]", глава 30 "Наследо вание"](https://github.com/igorsimdyanov/php8/tree/master/inherit/pages).

Для того что бы пример заработал:

### 1. Ставим Redis

```bash
sudo apt update && sudo apt install redis-server
```
Открываем файл конфигурации 

```bash
sudo vim /etc/redis/redis.conf
```

Вносим такие значения для директив
```config
supervised systemd
bind 127.0.0.1 ::1
maxmemory 200mb
maxmemory-policy volatile-ttl
```

Перезагружаем службу
```bash
sudo systemctl restart redis-server.service
```

Проверяем статус
```bash
sudo systemctl status redis-server.service
```

### 2. Создаем базу данных и пользователя
Если данные у вас будут отличатся, то их нужно изменить и в конструкторе StaticPage!
```bash
mysql>create database `php8db` default character set utf8 collate utf8_unicode_ci;

mysql>create user 'php8u'@'localhost' identified by 'qwerty';

mysql>grant all privileges on php8db.* to 'php8u'@'localhost';

mysql>flush privileges;

mysql>\q
```

### 3. Добавляем таблицу

```bash
mysql>CREATE TABLE `static_pages` (`ID` int NOT NULL AUTO_INCREMENT,
`TITLE` varchar(255) NOT NULL,
`CONTENT` TEXT NULL,
`DATE_INSERT` TIMESTAMP NOT NULL,
    PRIMARY KEY (`ID`)
);
```
### 4. Добавляем тестовые данные в таблицу
```bash
mysql>INSERT INTO `static_pages` (`TITLE`, `CONTENT`) VALUES ('Главная страница', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
```

### 3. Открываем индексный файл страницы
Например: http://polymorph_pages/index.php
При первой загрузке будет выведено сообщение о том что данные получены из БД, после чего данные для страницы (заголовок и контент) будут извлекатся из кеша (redis)






