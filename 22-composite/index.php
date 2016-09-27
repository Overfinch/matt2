<?php
// Реализация шаблона Composite

abstract class Unit {
    abstract function bombardStrength();
    abstract function addUnit(Unit $unit);
    abstract function removeUnit(Unit $unit);
}

class Archer extends Unit { // листья
    function addUnit(Unit $unit){}
    function removeUnit(Unit $unit){}

    function bombardStrength(){
        return 4;
    }
}

class LaserCannonUnit extends Unit { // листья
    function addUnit(Unit $unit){}
    function removeUnit(Unit $unit){}

    function bombardStrength(){
        return 44;
    }
}

class Army extends Unit{ // композит который может в себе объекты типа Unit
    private $units = [];
    private $armies = [];

    function addUnit(Unit $unit){ // добавление объекта типа Unit
        if(in_array($unit, $this->units, true)){
            return;
        }
        $this->units[] = $unit;
    }

    function removeUnit(Unit $unit){ // удаление объекта типа Unit
        $this->units = array_udiff($this->units, [$unit], function($a,$b){ return ($a === $b)?0:1; });
    }

    function addArmy(Army $army){ // добавление объекта типа Army
        array_push($this->armies, $army);
    }

    function bombardStrength(){ // возвращает силу всех Unit и Army объектов, которые находятся в нём
        $ret = 0;
        foreach ($this->units as $unit){
            $ret += $unit->bombardStrength();
        }

        foreach ($this->armies as $army){
            $ret += $army->bombardStrength();
        }

        return $ret;
    }

}

// классы Army и TroopCarrier - это композиты;
// Они предназначены для того что бы содержать в себе объекты типа Unit.
// Классы Archer и LaserCannon - это листья, предназначены для того что бы
// поддерживать операции с объектами типа Unit, и в них не могут содержатся другие объекты типа Unit

$archer1 = new Archer();
$LaserCannonUnit1 = new LaserCannonUnit();

$army = new Army();
$army->addUnit($archer1);
$army->addUnit($LaserCannonUnit1);
print $army->bombardStrength();
