<?php

$classname = "Task"; // имя класса который подключим

$path = $classname.".php";

if(!file_exists($path)){
    throw new Exception("файл".$path."не найден");
}

require_once($path); // подключаем файл с нужным нам классом

$qclassname = "tasks\\".$classname; // формируем имя класса с учетом пространства имён

if(!class_exists($qclassname)){
    throw new Exception("класс".$qclassname." не найден");
}

    $myObj = new $qclassname();
    $myObj->doSpeak();

echo "<pre>";
print get_class($myObj);
echo "</pre>";

// Work on PC