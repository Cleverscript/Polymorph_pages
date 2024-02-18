<?php
require_once 'cached.php';
include_once('pdo/CDatabase.php');
include_once('pdo/CQuery.php');

class StaticPage extends Cached
{
    // Конструктор класса
    public function __construct(protected ?int $id)
    {

        /** 
         * Инициализируем конструктор Cached
         * что бы создался экземплят хранилища Redis в $this->store
        */
        parent::__construct();

        // Проверяем, нет ли такой страницы в кэше
        if ($this->isCached($this->id($id))) {
            // Есть, инициализируем объект содержимым кэша
            parent::__construct($this->title(), $this->content());
        } else {

            echo "<strong style=\"color:red;\">Данные пока не кэшированы, извлекаем содержимое из базы данных</strong>";
            
            $dbh = new CDatabase('php8db', 'php8u', 'qwerty');
            $query = new CQuery(
                'SELECT * FROM `static_pages` WHERE id = :id LIMIT 1', 
                ['id' => $id],
                'php8db',
                $dbh
            );

            if ($page = $query->fetch()) {

                // Устанавливаем признак кэша страницы
                $this->set($this->id($id), 1);

                parent::__construct($page['TITLE'], $page['CONTENT']);
            }

        }
    }

    // Уникальный ключ для кэша
    public function id(mixed $name) : string
    {
      return "static_page_{$name}";
    }
}