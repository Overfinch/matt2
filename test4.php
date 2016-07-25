<?php

class Person {

    public $age = 30;

    public function __get($name)
    {
        $method = "get".$name;
        if(method_exists($this,$method)){
            return $this->$method();
        }
    }

    public function __call($name, $arguments)
    {
        $name = strtolower(str_replace("get","",$name));
        if(property_exists($this,$name)){
            return $this->$name;
        }
    }

    public function getName(){
        return "Ivan";
    }



}

$person = new Person();
echo $person->name;
echo $person->getAge();

echo "<pre>";
var_dump($_SERVER);
echo "</pre>";