<?php

// __tostring

class Person {
    public function getName(){
        return "Ivan";
    }
    
    public function getAge(){
        return 44;
    }

    public function __toString(){
        $desc = $this->getName().", ".$this->getAge()." лет";
        return $desc;
    }
}

$person = new Person();
echo $person;