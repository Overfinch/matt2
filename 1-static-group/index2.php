<?php

// Позднее статичное связываение

class Table {
    public static $name = 'table';
    public static function getName(){
        return static::$name; // static заменяется на имя класса из которого вызван, в данном случае на User::$name
        //return self::$name; // self сразу заменяется на имя класса в котором он обьявлен, и от куда он небыл бы вызван, всегда будет ссылатся на Table::$name
    }
}

class User extends Table {
    public static $name = 'user';
}

print User::getName();