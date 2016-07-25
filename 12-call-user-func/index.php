<?php

class Product{
    function getTitle(){
        return "Title";
    }

    static function getName(){
        return "Ivan";
    }
}

$product = new Product();
$method = "getTitle"; // имя метода в переменной
echo $product->$method(); // вызываем метод

echo "<br>";

$returnVal = call_user_func([$product,$method]); // вызываем метод call_user_func([обьект,имя метода])
echo $returnVal;

echo "<br>";

$name = call_user_func(["Product","getName"]); // так же можно вызвать статический метод
echo $name;