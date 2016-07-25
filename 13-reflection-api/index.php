<?php

// свединия о классе с помощью Reflection API
// ReflectionClass отвечает за информацию о классе, но есть много других, которые наследуют интерфейс Reflector
// http://php.net/manual/ru/book.reflection.php

require_once("../index.php");

$reflection = new ReflectionClass("CDProduct"); // создаём обьект класса ReflectionClass с классом Person

echo "<pre>";
Reflection::export($reflection); // Reflection::export() выводит сведения
echo "</pre>";
