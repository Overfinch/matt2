<?php

// ПРИМЕР НЕ ИЗ КНИГИ
// Суть паттерна в том, чтобы отделить инициатора и получателя команды.

class Lamp { // Receiver (Получатель)
    function turnOn() {
        echo "ON <br>";
    }

    function turnOff() {
        echo "OFF <br>";
    }
}

// начало Command
interface CommandInterface {
    public function execute();
}

class TurnOnCommand implements CommandInterface {
    protected $lamp;

    public function __construct(Lamp $lamp){
        $this->lamp = $lamp;
    }

    public function execute(){
        $this->lamp->turnOn();
    }
}

class TurnOffCommand implements CommandInterface {
    protected $lamp;

    public function __construct(Lamp $lamp){
        $this->lamp = $lamp;
    }

    public function execute(){
        $this->lamp->turnOff();
    }
}

class BlinkCommand implements CommandInterface { // паттерн Command позволяет нас добавить любую комманду (например эту - blink)
    protected $lamp;

    public function __construct(Lamp $lamp){
        $this->lamp = $lamp;
    }

    public function execute(){
        $this->lamp->turnOn();
        $this->lamp->turnOff();
        $this->lamp->turnOn();
        $this->lamp->turnOff();
    }
}
// конец Command

class CommandRegistry { // паттерн Registry
    private $registry = [];

    public function add(CommandInterface $command, $type){
        $this->registry[$type] = $command;
    }

    public function get($type){
        if(isset($this->registry[$type])){
            return $this->registry[$type];
        }
    }
}

$lamp = new Lamp();
$registry = new CommandRegistry();
$registry->add(new TurnOnCommand($lamp),"ON");
$registry->add(new TurnOffCommand($lamp),"OFF");
$registry->add(new BlinkCommand($lamp),"BLINK");

$registry->get("BLINK")->execute();