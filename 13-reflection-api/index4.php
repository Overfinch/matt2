<?php

// получаем исходный код метода с помощью Reflection Api
echo "<pre>";
require_once('../index.php');


class SourceCodeWriter {
    public static function write(ReflectionMethod $method){ // принимаеи метод в виде обьекта класса ReflectionMethod
        $fileName = $method->getFileName(); // получаем путь имя файла где содержится метод
        $code_arr = file($fileName); // записываем все строки этого файла в массив
        $start = $method->getStartLine()-1; // получаем номер строки где начинается код нашего метода
        $end = $method->getEndLine()-1; // получаем номер строки где заканчивается код нашего метода
        $length = $end-$start+1; // высчитываем количество строк (длинну)
        $code_arr = array_slice($code_arr,$start,$length); // обрезаем массив со строками, что бы оставить только строки где описан код нашего метода
        $code = implode("<br>",$code_arr); // превращаем массив со строками в строку
        print_r($code); // выводим код
    }
}

$class = new ReflectionClass("CDProduct");  // поучаем обьект класса ReflectionClass для CDProduct
$method = $class->getMethod("getSummaryLine"); // получаем метода getSummaryLine класса CDProduct
SourceCodeWriter::write($method); // вызываем наш сетод который выводит исходный код


echo "</pre>";