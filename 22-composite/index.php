<?php
// Реализация шаблона Composite

class UnitException extends Exception {}

abstract class Unit {
    abstract function bombardStrength();

    function addUnit(Unit $unit){
        throw new UnitException(self::class.' относится к листьям');
    }
    function removeUnit(Unit $unit){
        throw new UnitException(self::class.' относится к листьям');
    }
    // исключения на случай если к "листьям" попробуют добавить или удалить что-то
    // а для "композитов" будут обьявлены рабочие методы addUnit и removeUnit
}

class Archer extends Unit { // листья
    function bombardStrength(){
        return 4;
    }
}

class LaserCannonUnit extends Unit { // листья
    function bombardStrength(){
        return 44;
    }
}

class Army extends Unit{ // композит который может в себе объекты типа Unit
    private $units = [];

    function addUnit(Unit $unit){ // добавление объекта типа Unit
        if(in_array($unit, $this->units, true)){
            return;
        }
        $this->units[] = $unit;
    }

    function removeUnit(Unit $unit){ // удаление объекта типа Unit
        $this->units = array_udiff($this->units, [$unit], function($a,$b){ return ($a === $b)?0:1; });
    }

    function bombardStrength(){ // возвращает силу всех Unit и Army объектов, которые находятся в нём
        $ret = 0;
        foreach ($this->units as $unit){
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}

// класс Army - это композит (их тоже может быть много, как и листьев);
// Они предназначены для того что бы содержать в себе объекты типа Unit.
// Классы Archer и LaserCannon - это листья, предназначены для того что бы
// поддерживать операции с объектами типа Unit, и в них не могут содержатся другие объекты типа Unit

// создадим армию
$main_army = new Army();

// добавим пару боевых едениц
$main_army->addUnit(new Archer());
$main_army->addUnit(new LaserCannonUnit());

// создадим ещё армию
$sub_army = new Army();

//добавим ей несколько боевых едениц
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());

// добавим вторую армию к первой
$main_army->addUnit($sub_army);

// Все вычисления выполняются за кулисами
print $main_army->bombardStrength();
