<?php

// __destruct

class Person {
    public $name;
    public $age;
    public $id;

    public function __construct($name, $age){
        $this->name = $name;
        $this->age = $age;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function __destruct(){
        if(!empty($this->id)){
            echo "Сохраняем обьект в БД";
        }
    }
}

$person = new Person("Ivan", 44);
$person->setId(1);
unset($person);