<?php

//ООП подход
// суть в том что основной класс определяет что за формат у файла, и создаёт объект нужного подкласса
// какие-то общие операции(которые не привязаны к фармату) которые будут производится над объектом, описаны в основном классе ParamHandler
// а те которые работают со своим форматом, уже будут описаны в нужном подклассе


abstract class ParamHandler{
    protected $source; // файл
    protected $params = []; // параметры

    public function __construct($source){
        $this->source = $source;
    }

    function addParam($key, $val){ // добавление параметров в массив $this->params
        $this->params[$key] = $val;
    }

    function getAllParams(){ // вывод параметров из массива $this->params
        return $this->params;
    }

    static function getInstance($filename){ // в зависимости от расширения файла, создаём разные обьекты наших подклассов
        if(preg_match("/\.xml$/i",$filename)){
            return new XMLParamHandler($filename); // для xml файла
        }else{
            return new TextParamHandler($filename); // для txt файла
        }
    }

    abstract function write(); // абстрактные методы которые будут реализованы уже в подклассах
    abstract function read();
}

class XMLParamHandler extends ParamHandler{
    function write(){
        // запись в файл в формате XML, параметров из массива $this->params
    }
    function read(){
        // чтение из XML файла
        // и запись в массив $this->params
    }
}

class TextParamHandler extends ParamHandler{
    function write(){
        // запись в файл в формате txt, параметров из массива $this->params
    }
    function read(){
        // чтение из txt файла
        // и запись в массив $this->params
    }
}

$test = ParamHandler::getInstance("params.txt"); // создаёт объект класса TextParamHandler !!!

