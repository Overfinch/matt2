<?php

// Условный код модуля
// ----------------------------------------------------------------------------------

function getProductFileLines($file){
    return file($file);
}

function getProductObjectFormId($id, $productname){
    return new Product($id, $productname);
}

function getNameFromLine($line){
    if(preg_match("/.*-(.*)\s\d+/", $line, $array)){
        return str_replace('_',' ', $array[1]);
    }
    return '';
}

function getIDFromLine($line){
    if(preg_match("/^(\d{1,3})-/", $line, $array)){
        return $array[1];
    }
    return -1;
}

class Product {
    public $id;
    public $name;

    function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
    }
}
// ----------------------------------------------------------------------------------


// Так из клиентского кода вызывается без фасада
$lines = getProductFileLines('test.txt');
$objects = [];
foreach ($lines as $line){
    $id = getIDFromLine($line);
    $name = getNameFromLine($line);
    $objects[$id] = getProductObjectFormId($id, $name);
}

echo "<pre>";
print_r($objects);
echo "</pre>";
echo "<hr>";

// ----------------------------------------------------------------------------------
// Сам фасад, одна точка входа в которой удобно скомпонованы основные функции

class ProductFacade {
    private $products = [];
    private $file;

    function __construct($file) {
        $this->file = $file;
        $this->compile();
    }

    private function compile(){
        $lines = getProductFileLines($this->file);
        foreach ($lines as $line){
            $id = getIDFromLine($line);
            $name = getNameFromLine($line);
            $this->products[$id] = getProductObjectFormId($id, $name);
        }
    }

    function getProducts(){
        return $this->products;
    }

    function getProduct($id){
        if(isset($this->products[$id])){
            return $this->products[$id];
        }
        return null;
    }
}

// ----------------------------------------------------------------------------------
// А так вызывается с фасадом

echo "<pre>";
$facade = new ProductFacade('test.txt');
print_r($facade->getProducts());
echo $facade->getProduct(234)->name;
echo "</pre>";