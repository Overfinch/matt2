<?php

namespace my;
//use com\useful;  // используем пространство имён com\useful и неявно назначаем ему имя useful\
use com\useful\Outputer as uOutputer;  // используем пространство имён com\useful и явно назначаем ему имя uDebug
require_once "useful/Outputer.php";

class Outputer{
    static function show(){
        echo "my Outputer<br>";
    }
}

Outputer::show(); //класс из этого кода
uOutputer::show(); // класс из запрошенного кода
