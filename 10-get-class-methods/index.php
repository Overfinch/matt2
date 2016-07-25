<?php

class Person{
    public $age = 32;
    public static function getName(){
        return "Ivan";
    }
}

print_r(get_class_methods("Person")); // возвращает имена методов
echo "<br>";
print_r(get_class_vars("Person")); // возвращает имена свойств
echo "<br>";

$methodname = "getName"; // имя метода

if(is_callable(['Person',$methodname])){ // проверяем есть ли такой метод в классе (и вызывается ли он)
    echo Person::$methodname(); // вызываем его
}
