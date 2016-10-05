<?php
// Реализация шаблона Composite

class UnitException extends Exception {}

abstract class Unit {

    function getComposite(){ // указывает что это не композит, а листья
        return null;
    }

    abstract function bombardStrength();
}

abstract class CompositeUnit extends Unit {
    private $units = [];

    function getComposite(){ // возвращает сам себя для того что бы определить что это композит, и дальше взаимодействовать с ним
        return $this;
    }

    function units(){
        return $this->units;
    }

    function addUnit(Unit $unit){ // добавление объекта типа Unit
        if(in_array($unit, $this->units, true)){
            echo "этот юнит уже есть в массиве";
            return;
        }
        $this->units[] = $unit;
    }

    function removeUnit(Unit $unit){ // удаление объекта типа Unit
        $this->units = array_udiff($this->units, [$unit], function($a,$b){ return ($a === $b)?0:1; });
    }
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

class Army extends CompositeUnit { // композит который может в себе объекты типа Uni

    function bombardStrength(){ // возвращает силу всех Unit и Army объектов, которые находятся в нём
        $ret = 0;
        foreach ($this->units() as $unit){
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}

// Методу joinExisting() передаются два объекта типа Unit.
// Первый- это объект, вновь прибывший на клетку,
// а второй - объект. который занимал клетку до этого.
// Если второй объект типа Unit принадлежит к клaccy CompositeUnit,
// то первый объект попытается присоединиться к нему. Если нет,
// то будет создан новый объект типаАrmу, включающий оба объекта типа Unit.
class UnitScript {
    static function joinExisting(Unit $newUnit, Unit $occupyingUnit){
        if(! is_null($comp = $occupyingUnit->getComposite())){
            $comp->addUnit($newUnit);
        }else{
            $comp = new Army();
            $comp->addUnit($occupyingUnit);
            $comp->addUnit($newUnit);
        }
        return $comp;
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
echo "<hr>";


// Тут имитируем ситуацию когда $main_army был в клетке и в неё пришел ещё new Archer()
// joinExisting() определил что $main_army это композит и добавил к нему new Archer()
// и вернул ТОТ ЖЕ объект(не создавал новый) типа Army ($main_army)
$new_army = UnitScript::joinExisting(new Archer(),$main_army);
print $new_army->bombardStrength();