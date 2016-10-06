<?php

abstract class Tile { // Клетка в которой могут находится боевые еденицы
    abstract function getWealthFactor();
}

class Plains extends Tile {
    private $wealthFactor = 2;

    function getWealthFactor(){
        return $this->wealthFactor;
    }
}

abstract class TileDecorator extends Tile {
    protected $tile;

    function __construct(Tile $tile){
        $this->tile = $tile;
    }
}

/*----------------------------------------------*/
class DiamondDecorator extends TileDecorator {
    function getWealthFactor(){
        return $this->tile->getWealthFactor() + 2;
    }
}

class PolutedDecorator extends TileDecorator {
    function getWealthFactor(){
        return $this->tile->getWealthFactor() - 4;
    }
}
// Каждый из этих классов расширяет TileDecorator.
// Это означает, что у них есть ссылка на объект типа Tile.
// Когда вызывается метод getWealthFactor ()...
// каждый из этих классов сначала вызывает такой же метод у объекта типа Tile,
// а затем выполняет собственную корректировку значения.
/*----------------------------------------------*/


$tile = new DiamondDecorator(new Plains());
// В объекте типа DiamondDecorator хранится ссылка на объект типа Plains.
// Перед прибавлением собственного значения +2
// он вызывает метод getWealthFactor() объекта типа Plains
print $tile->getWealthFactor();

echo "<br>";
$tile2 = new PolutedDecorator(new DiamondDecorator(new Plains()));
// так же можно одновременно применять несколько декораторов
print $tile2->getWealthFactor();