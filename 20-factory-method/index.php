<?php

abstract class ApptEncoder {
    abstract function encode();
}

class BlogsApptEncoder extends ApptEncoder {
    function encode(){
        return "Данные о встрече закодированы в формате BlogsCall <br>";
    }
}

class MegaApptEncoder extends ApptEncoder {
    function encode(){
        return "Данные о встрече закодированы в формате MegaCall <br>";
    }
}

class CommsManager {
    const BLOGS = 1;
    const MEGA = 2;
    private $mode = 1;

    function __construct($mode){
        $this->mode = $mode;
    }

    function getHeaderText(){
        switch ($this->mode){
            case (self::MEGA):
                return "MegaCall верхний колонтикул <br>";
            default:
                return "BlogsCall верхний колонтикул <br>";
        }
    }

    function getApptEncoder(){
        switch ($this->mode){
            case (self::MEGA):
                return new MegaApptEncoder();
            default:
                return new BlogsApptEncoder();
        }
    }
}

$comms = new CommsManager(CommsManager::MEGA);
$apptEncoder = $comms->getApptEncoder();
print $apptEncoder->encode();
print $comms->getHeaderText();
