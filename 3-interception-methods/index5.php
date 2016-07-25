<?php

// замыкания

class Product {
    public $name;
    public $price;

    public function __construct($name, $price){
        $this->name = $name;
        $this->price = $price;
    }
}

class ProcessSale{
    private $callbacks;

    function registerCallback($callback){ // записываем функции в массив $callbacks
        if(!is_callable($callback)){
            throw new Exception("Функция обратного вызова не вызываема");
        }

        $this->callbacks[] = $callback;
    }

    function sale(Product $product){ // перебераем все функции из массивы $callbacks и передаём им $product
        foreach($this->callbacks as $callback){
            call_user_func($callback, $product);
        }
    }
}

class Mailer {
    function doMail(Product $product){
        print "Упаковываем ".$product->name."<br>";
    }
}

class Totalizer {
    static function warnAmount($count){
        return function(Product $product)use($count){
            if($product->price > 5){
                print "Покупается дорогой товар <br>";
            }
            print "Покупаються $count товаров на цену ".$count*$product->price."<br>";
        };
    }
}

$logger = function(Product $product){print "Записываем ".$product->name."<br>";}; // создаём функцию и записываем в переменую $loger

$product = new Product("Туфли", 100);
$product2 = new Product("Ботинки", 150);

$mailer = new Mailer();

$processor = new ProcessSale();
$processor->registerCallback($logger); // регистрируем в классе анонимную функцию
$processor->registerCallback([$mailer, "doMail"]); // регистрируем в классе функцию из другого класса
$processor->registerCallback(Totalizer::warnAmount(8)); // регистрируем в классе статическую функцию из другого класса

$processor->sale($product);
$processor->sale($product2);