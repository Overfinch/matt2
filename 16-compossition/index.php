<?php

// решение задачи без КОМПОЗИЦИИ!!!

abstract class Lesson{
    protected $duration;
    const FIXED = 1;
    const TIMED =2;
    private $costType;

    public function __construct($duration, $costType = 1){
        $this->duration = $duration;
        $this->costType = $costType;
    }

    public function cost(){
        if($this->costType == self::TIMED){
            return 5 * $this->duration;
        }elseif ($this->costType == self::FIXED){
            return 30;
        }else{
            $this->costType = self::FIXED;
            return 30;
        }
    }

    public function chargeType(){
        if($this->costType == self::FIXED){
            return "Фиксированая цена";
        }elseif ($this->costType == self::TIMED){
            return "почасовая оплата";
        }
    }
}

class Lecture extends Lesson{

}

class Seminar extends Lesson{

}

$leson1 = new Lecture(4,Lesson::FIXED);
$leson2 = new Seminar(5,Lesson::TIMED);

print "{$leson1->chargeType()} - {$leson1->cost()} <br>";
print "{$leson2->chargeType()} - {$leson2->cost()} <br>";