<?php


Class Vehicle {
    public $color ;
    public $body_type;
    public $drive_type;

    public function __construct($color, $body_type, $drive_type){
        $this->color = $color;
        $this->body_type = $body_type;
        $this->drive_type = $drive_type;
    }

    public function showInfo(){
        return $this->color." ".$this->body_type.' '.$this->drive_type;
    }
}

class Truck extends Vehicle {
    public $capacity;

    public function __construct($color, $body_type, $drive_type, $capacity)
    {
        parent::__construct($color, $body_type, $drive_type);
        $this->capacity = $capacity;
    }

    public function showInfo()
    {
        $data = parent::showInfo();
        $data .= ' '.$this->capacity;
        return $data;
    }
}

class SportCar extends Vehicle {
    public $max_speed;

    public function __construct($color, $body_type, $drive_type, $max_speed)
    {
        parent::__construct($color, $body_type, $drive_type);
        $this->max_speed = $max_speed;
    }

    public function showInfo()
    {
        $data = parent::showInfo();
        $data .= $this->max_speed;
        return $data;
    }
}

class Tracer {

    public static function trace($text){
        if(is_array($text)){
            print "<pre>";
            print_r($text);
            print "</pre>";
        }elseif(is_string($text)){
            print "<pre>".$text."</pre>";
        }else{
            print "<pre>";
            var_dump($text);
            print "</pre>";
        }

    }

    public static function traceArray(array $array){

    }
}

class Factory {
    public $cars;
    public $objects=[];
    public $str='';

    public function addCars(array $array){
        $this->cars = $array;
        foreach($this->cars as $car){
            if($car['type'] == "SportCar"){
                $obj = new Sportcar($car['color'], $car['body_type'],$car['drive_type'],$car['max_speed']);
            }elseif($car['type'] == "Truck"){
                $obj = new Truck($car['color'], $car['body_type'],$car['drive_type'],$car['capacity']);
            }
            $this->objects[] = $obj;
        }
    }

    public function showCars(){
        foreach($this->objects as $object){
            $this->str .= $object->showInfo()."<br>";
        }
        return $this->str;
    }
}

class StaticFactory {
    public static function printCars(array $array){
        $data ='';
        foreach($array as $car){
            if($car['type'] == "SportCar"){
                $object = new SportCar($car['color'], $car['body_type'],$car['drive_type'],$car['max_speed']);
            }elseif($car['type'] == "Truck"){
                $object = new SportCar($car['color'], $car['body_type'],$car['drive_type'],$car['capacity']);
            }
             $data .= $object->showInfo()."<br>";
        }
        print $data;
    }
}

$cars = [
         ['name' => 'subaru',
             'type' => 'SportCar',
         'color' => 'blue',
         'body_type' => 'sedan',
         'drive_type' => 'full wheel',
             'max_speed' => 300
         ],[
        'name' => 'man',
        'type' => 'Truck',
        'color' => 'black',
        'body_type' => 'truck',
        'drive_type' => 'rear wheel',
        'capacity' => 300
    ]

];


//Tracer::trace($cars);

$factory = new Factory();
$factory->addCars($cars);

Tracer::trace($factory->showCars());
echo "<hr>";

StaticFactory::printCars($cars);
