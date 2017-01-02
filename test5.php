<?php

abstract class Veichle {
    abstract function getName();
}

class Car extends Veichle {
    public $name;
    public $color;

    public function __construct($name, $color){
        $this->name = $name;
        $this->color = $color;
    }

    public function getName(){
        return $this->name;
    }
}

class CarDecorator extends Veichle {
    protected $vechile;
    public function __construct(Veichle $vechile){
        $this->vechile = $vechile;
    }

    public function getName(){
    }
}

class BoldCarDecorator extends CarDecorator {
    public function getName(){
        return "<b>".$this->vechile->getName()."</b>";
    }
}

class RedCarDecorator extends CarDecorator {
    public function getName(){
        return "<p style='color: crimson'>".$this->vechile->getName()."</p>";
    }
}

$audi = new RedCarDecorator(new BoldCarDecorator(new Car('Audi','black')));
echo $audi->getName();
