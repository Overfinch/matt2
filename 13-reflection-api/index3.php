<?php

// Исследования методов с помощью Reflection Api
echo "<pre>";
include_once('../index.php');


function methodData(ReflectionMethod $method){
    $data = "";
    $name = $method->getName();

    if($method->isUserDefined()){
        $data .= "$name -- метод определён пользователем<br>";
    }

    if($method->isInternal()){
        $data .= "$name -- внутренний метод<br>";
    }

    if($method->isAbstract()){
        $data .= "$name -- абстрактный метод<br>";
    }

    if($method->isPublic()){
        $data .= "$name -- public метод<br> ";
    }

    if($method->isProtected()){
        $data .= "$name -- protected метод<br> ";
    }

    if($method->isPrivate()){
        $data .= "$name -- private метод<br> ";
    }

    return $data;
}

$prod_class = new ReflectionClass("CDProduct"); // поучаем обьект класса ReflectionClass для CDProduct
$methods = $prod_class->getMethods(); // получаем все методы класса CDProduct

foreach ($methods as $method) { 
    print methodData($method);
    print "<hr>";
}


echo "</pre>";