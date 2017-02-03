<?php

class Table {
    public static $name = 'table';
    public static function getName(){
        return static::$name;
    }
}

class User extends Table {
    public static $name = 'user';
}

print User::getName();