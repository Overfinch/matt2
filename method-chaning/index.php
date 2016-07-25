<?php

// Соединение методов

class Maker {
    public $string;

    public function addFirst($str){
        $this->string = $str;
        return $this; // метод возвращает объект, и после этого к нему можно применять следующий метод
    }

    public function addSecond($str){
        $this->string .= $str;
        return $this; // метод возвращает объект, и после этого к нему можно применять следующий метод
    }

    public function show(){
        return $this->string;
    }
}

$string = new Maker();
$string->addFirst("hello")->addSecond(" world"); // вот так

echo $string->show();