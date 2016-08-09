<?php

// реализация паттерном Strategy

abstract class Lesson {
    private $duration; // продолжительность
    private $costStrategy; // объект CostStrategy

    public function __construct($duration, CostStrategy $costStrategy){ // принимает подолжительность занятия, и Стратегию которая будет генерировать данные в зависимости от вида оплаты
        $this->duration = $duration;
        $this->costStrategy = $costStrategy;
    }

    public function cost(){
        return $this->costStrategy->cost($this); // высчитывает стоимость через стратегию и передаёт экземпляр себя(в данном случае для того что бы стратегия знала $this->duration)
    }

    public function chargeType(){
        return $this->costStrategy->chargeType(); // выводит вид оплаты
    }

    public function getDuration(){
        return $this->duration;
    }
}

class Lecture extends Lesson{}
class Seminar extends Lesson{}

abstract class CostStrategy {
    abstract function cost(Lesson $lesson);
    abstract function chargeType();
}

class FixedStrategy extends CostStrategy{
    public function cost(Lesson $lesson) {
        return 30;
    }

    public function chargeType(){
        return "фиксированая цена";
    }
}

class TimedStrategy extends CostStrategy{
    public function cost(Lesson $lesson){
        return 5 * $lesson->getDuration(); // здесь высчитывается цена, исходя из продолжительности ($lesson->getDuration())
    }

    public function chargeType(){
        return "почасовая оплата";
    }
}

$leson1 = new Lecture(5,new FixedStrategy);
print "Вид оплаты - {$leson1->chargeType()}, продолжительность - {$leson1->getDuration()}, цена - {$leson1->cost()}<br>";
$leson2 = new Lecture(5,new TimedStrategy());
print "Вид оплаты - {$leson2->chargeType()}, продолжительность - {$leson2->getDuration()}, цена - {$leson2->cost()}<br>";