<?php

// с помощью Reflection API получаем исходный код класса
echo "<pre>";
require_once ('../index.php');


class ReflectionUtil {
    public static function getClassSource(ReflectionClass $class){ // принимаем обьект класа ReflectionClass
        $path = $class->getFileName(); // получаем полный путь к файлу
        $lines = file($path); // получаем массив со всем строчками кода из файла
        $from = $class->getStartLine(); // номер строки начала кода класса
        $to = $class->getEndLine(); // номер строки конца кода класса
        $len = $to-$from+1; // длинна строк
        return implode(array_slice($lines,$from-1,$len)); // вырезаем только нудный нам кусок массива(кода) и превращаем его в строку
    }
}

$class = new ReflectionClass("CDProduct");
print ReflectionUtil::getClassSource($class);
echo "</pre>";