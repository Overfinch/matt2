<?php
// Реализация шаблона Composite

abstract class Unit {
    abstract function bombardStrength();
    abstract function addUnit(Unit $unit);
    abstract function removeUnit(Unit $unit);
}

class Archer extends Unit {
    function addUnit(Unit $unit){}
    function removeUnit(Unit $unit){}

    function bombardStrength(){
        return 4;
    }
}

class LaserCannonUnit extends Unit {
    function addUnit(Unit $unit){}
    function removeUnit(Unit $unit){}

    function bombardStrength(){
        return 44;
    }
}

class Army extends Unit{
    private $units = [];
    private $armies = [];

    function addUnit(Unit $unit){
        array_push($this->units, $unit);
    }

    function removeUnit(Unit $unit){
        $this->units = array_udiff($this->units, [$unit], function($a,$b){return ($a === $b)?0:1; });
    }

    function addArmy(Army $army){
        array_push($this->armies, $army);
    }

    function bombardStrength(){
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

$army = new Army();
$army->addUnit(new Archer());
$army->addUnit(new LaserCannonUnit());
print $army->bombardStrength();