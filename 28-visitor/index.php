<?php

// Реализация паттерна Visitor на примере нашего прошлого паттерна Composite

abstract class ArmyVisitor {
    abstract function visit(Unit $node);

    function visitArcher(Archer $node){
        $this->visit($node);
    }

    function visitLaserCannonUnit(LaserCannonUnit $node){
        $this->visit($node);
    }

    function visitArmy(Army $node){
        $this->visit($node);
    }
}

class TextDumpArmyVisitor extends ArmyVisitor {
    private $text="";

    function visit(Unit $node){
        $txt = '';
        $pad = 4*$node->getDepth();
        $txt .= sprintf("%{$pad}s", "");
        $txt .= get_class($node).": ";
        $txt .= "Огневая мощь: ". $node->bombardStrength()."<br>";
        $this->text .= $txt;
    }

    function getText(){
        return $this->text;
    }
}

class TaxCollectionVisitor extends ArmyVisitor {
    private $due=0;
    private $report='';

    function visit(Unit $node){
        $this->levy($node, 1);
    }

    function visitArcher(Archer $node)
    {
        $this->levy($node, 2);
    }

    function visitLaserCannonUnit(LaserCannonUnit $node)
    {
        $this->levy($node, 5);
    }

    function levy(Unit $unit, $amount){
        $this->report .= "Налог для ". get_class($unit);
        $this->report .= ": ".$amount."<br>";
        $this->due += $amount;
    }

    function getReport(){
        return $this->report;
    }

    function getTax(){
        return $this->due;
    }

}

abstract class Unit{
    protected $depth = 0; // глубина вложенности

    function accept(ArmyVisitor $visitor){ // генерируем имена методов для визитора  и вызываем их что бы не создавать метод accept для каждого Unit, но все эти методы надо будет прописать в самом Visitor`е
        $method = "visit".get_class($this);
        $visitor->$method($this);
    }

    protected function setDepth($depth){
        $this->depth = $depth;
    }

    function getDepth(){
        return $this->depth;
    }

    abstract function bombardStrength();
}

abstract class CompositeUnit extends Unit { //
    protected $units = [];

    function accept(ArmyVisitor $visitor){
        parent::accept($visitor);
        foreach ($this->units as $unit){ // проделываем то же для каждого Юнита
            $unit->accept($visitor);
        }
    }

    function units(){
        return $this->units;
    }

    function addUnit(Unit $unit){
        if(in_array($unit, $this->units, true)){
            print "этот юнит уже есть в композите <br>";
            return;
        }
        $unit->setDepth($this->depth+1); // при вложении, изменяем глубину вложенности Юнита
        $this->units[] = $unit;
    }

    function removeUnit(Unit $unit){
        $this->units = array_udiff($this->units, [$unit], function($a,$b){ return ($a === $b)?0:1; });
    }
}

class Archer extends Unit {
    function bombardStrength(){
        return 4;
    }
}

class LaserCannonUnit extends Unit { // листья
    function bombardStrength(){
        return 44;
    }
}

class Army extends CompositeUnit {
    function bombardStrength(){
        $ret = 0;
        foreach ($this->units() as $unit){
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}

$main_army = new Army();
$main_army->addUnit(new Archer());
$main_army->addUnit(new Archer());
$main_army->addUnit(new LaserCannonUnit());

$textDump = new TextDumpArmyVisitor();
$taxCollector = new TaxCollectionVisitor();

$main_army->accept($textDump); // генерирует и выполняет для себя и всех своих юнитов TextDumpArmyVisitor::visit..., в результате объект TextDumpArmyVisitor посетит каждый объект на дереве
$main_army->accept($taxCollector);

print $textDump->getText();
print $taxCollector->getReport();
print $taxCollector->getTax();