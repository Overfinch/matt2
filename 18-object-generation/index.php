<?php


abstract class Employee {
    protected $name;
    private static $types = ['Minion','WellConnected','CluedUp']; // типы дочерних классов

    static function recruit($name){
        $num = mt_rand(0, count(self::$types)-1);
        $type = self::$types[$num];
        return new $type($name);  // возвращаем экземпляр рандомного дочернего класса
    }

    public function __construct($name){
        $this->name = $name;
    }

    abstract function fire();
}

class Minion extends Employee {
    public function fire(){
        print $this->name." Убери со стола <br>";
    }
}

class WellConnected extends Employee {
    public function fire(){
        print $this->name." Позвони папику <br>";
    }
}

class CluedUp extends Employee {
    public function fire(){
        print $this->name." Вызови адвоката <br>";
    }
}

class NastyBoss {
    private $employees = [];

    public function addEmployee(Employee $employee){
        $this->employees[] = $employee;
    }

    public function projectFails(){
        if (count($this->employees) > 0){
            $emp = array_pop($this->employees);
            $emp->fire();
        }
    }
}

$boss = new NastyBoss();

$boss->addEmployee(Employee::recruit('Nikolai'));
$boss->addEmployee(Employee::recruit('Anna'));
$boss->addEmployee(Employee::recruit('Ivan'));
$boss->addEmployee(Employee::recruit('John'));

$boss->projectFails();
$boss->projectFails();
$boss->projectFails();