<?php

// Позднее статическое связывание
// интерпретатор ищет вызываемые методы, сначала из класса где они вызываются,
// а потом поднимается вверх до основного родительского класса, пока не найдёт метод

abstract class DomainObject{
    private $group;

    public function __construct(){
        $this->group = static::getGroup(); // Вызывает метод getGroup() из того класса где он был создан, а потом ищет в следующем родительском, и так до самого верха
    }

    public static function create(){
        return new static(); // возвращает экземпляр класса, через который обратились к этому методду (в данном случае Document)
    }

    public function getGroup(){
        return "default";
    }
}

class User extends DomainObject {}

class Document extends DomainObject {
    public function getGroup(){
        return "document";
    }
}

class SpreadSheet extends Document {}

print_r(SpreadSheet::create());
print "<br>";
print_r(User::create());