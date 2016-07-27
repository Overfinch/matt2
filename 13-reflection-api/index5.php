<?php

// исследования аргументов методов с помощью Reflection Api
echo "<pre>";
require_once('../index.php');


class ArgData{
    public static function show(ReflectionParameter $parameter){
        $data = '';
        $declaringClass = $parameter->getDeclaringClass();
        $name = $parameter->getName();
        $class = $parameter->getClass();
        $possition = $parameter->getPosition();
        $data .= "$name находится на позиции $possition <br>";
        if(!empty($class)){
            $className = $class->getName();
            $data .= "аргумент $name должен быть обьектом класса $className";
        }

        if($parameter->isPassedByReference()){
            $data .= "аргумент $name передан по ссылке";
        }

        if($parameter->isDefaultValueAvailable()){
            $def = $parameter->getDefaultValue();
            $data .= "значение по умолчанию - $def";
        }

        $data .="<hr>";
        print $data;
    }
}


$class = new ReflectionClass("CDProduct");
$method = $class->getMethod("__construct");
$params = $method->getParameters();

foreach ($params as $param){
    ArgData::show($param);
}

echo "</pre>";
