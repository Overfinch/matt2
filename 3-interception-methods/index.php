<?php

class Person {

    private $writer;

    public function __construct(PersonWriter $writer){
        $this->writer = $writer;
    }

    public function __call($methodName, $arguments){ // вызывается когда обращаются к необьявленному методу
        if(method_exists($this->writer,$methodName)){
            return $this->writer->$methodName($this);
        }
    }

    public function getName(){
        return "Ivan";
    }

    public function getAge(){
        return 44;
    }

}

class PersonWriter{

    function writeName(Person $p){
        echo $p->getName();
    }

    function writeAge(Person $p){
        echo $p->getAge();
    }
}

$p = new Person(new PersonWriter());
$p->writeName();