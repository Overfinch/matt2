<?php

$classname = "Task"; // имя класса который подключим

require_once($classname.".php"); // подключаем файл с нужным нам классом

$classname = "tasks\\".$classname; // формируем имя класса с учетом пространства имён

$myObj = new $classname(); 
$myObj->doSpeak();