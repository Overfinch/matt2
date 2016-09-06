<?php


class Sea {
    private $navigability = 0; // количество очков хода, которое теряет игрок перемещаесь по данной поверхности
    function __construct($navigability){
        $this->navigability = $navigability;
    }
}

class MarsSea extends Sea {}
class EarthSea extends Sea {}

class Plains {}

class MarsPlains extends Plains {}
class EarthPlains extends Plains {}

class Forest {}

class MarsForest extends Forest {}
class EarthForest extends Forest {}

class TerrainFactory {
    private $sea;
    private $forest;
    private $plains;

    function __construct(Sea $sea, Plains $plains, Forest $forest){
        $this->sea = $sea;
        $this->plains = $plains;
        $this->forest = $forest;
    }

    function getSea(){
        return clone $this->sea;
    }

    function getForest(){
        return clone $this->forest;
    }

    function getPlains(){
        return clone $this->plains;
    }
}

// вместо того что бы описывати классы типа MarsTerrainFactory и EarthTerrainFactory
// мы сами создаём прототип фабрики в которую передаём экземпляры нужных нам классов

$factory = new TerrainFactory(new EarthSea(1), new EarthPlains(), new EarthForest());
// Здесь мы загружаем в экземпляр конкретной фабрики типа TerrainFactory экземпляры объектов наших "поверхностей".
// Когда в клиентском коде вызывается метод getSea(), ему возвращается клон объекта Sea,
// который мы поместили в кэш во время инициализации. Так мы не только сократили пару классов, но и получили гибкость,
// можно создать фабрику которая, например создаёт планету с морями и лесами как на Земле, и с равнинами как на марсе.
echo "<pre>";
var_dump($factory->getSea());
var_dump($factory->getPlains());
var_dump($factory->getForest());
echo "<pre>";