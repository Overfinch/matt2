<?php

// Реализация Singletone

class Preferences {
    private $props = []; // тут хранятся свойства
    private static $instance; // тут хранится экземпляр объекта этого класса

    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new Preferences(); // если экземпляр не создан, создаём его
        }
        return self::$instance; // получаем экземпляр объекта этого класса
    }

    private function __construct(){} // закрываем конструктор

    public function setProperty($key,$val){ // устанавливаем свойство
        $this->props[$key] = $val;
    }

    public function getProperty($key){ // получаем свойство
        return $this->props[$key];
    }
}

$pref = Preferences::getInstance(); // получаем экземпляр объекта
$pref->setProperty("name","Ivan"); // устанавливаем свойство

unset($pref); // удаляем ссылку на объект

$pref2 = Preferences::getInstance(); // сново получаем тот же экземпляр объекта
echo $pref2->getProperty("name"); // и получаем то же свойство что задали ранее