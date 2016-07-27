<?php
// пишем класс который проверяет, и подключает модули и передаёт им нужные аргументы
echo "<pre>";

class Person{
    public $name;

    public function __construct($name){
        $this->name = $name;
    }
}

interface Module{
    function execute();
}

class FtpModule implements Module{
    public function setHost($host){
        print "FtpModule::setHost() $host <br>";
    }

    public function setUser($user){
        print "FtpModule::setUser() $user <br>";
    }

    public function execute(){
        // выполнение
    }
}

class PersonModule implements Module{
    public function setPerson(Person $person){
        print "PersonModule::setPerson() $person->name <br>";
    }

    public function execute(){
        // выполнение
    }
}

class ModuleRunner{
    private $configData = [ // массив с именами модулей и данными ["имя модуля" => ["имя метода" => "аргумент"]]
        "PersonModule" => ["person" => 'bob'],
        "FtpModule" =>['host' => 'localhost', "user" => "anon"]
    ];

    private $modules = []; // массив в который запишем созданые объекты модулей

    public function init(){
        $interface = new ReflectionClass("Module"); // интерфейс который должны наследовать все модули
        foreach ($this->configData as $moduleName => $params){
            $moduleClass = new ReflectionClass($moduleName); // создаём новые ReflectionClass для класса каждого модуля
            if(!$moduleClass->isSubclassOf($interface)){ // проверяем наследует ли он интерфейс Module
                throw new Exception("Неизвестный тип модуля $moduleName");
            }

            $module = $moduleClass->newInstance(); // создаём объект класса модуля (аналог new PersonModule() и тд)
            foreach ($moduleClass->getMethods() as $method){ // перебераем все методы модулей
                $this->handleMethod($module, $method, $params); // передаём следующему методу $module(оозданый обьект модуля, $method(метод модуля в виде ReflectionMethod), $params(массив с параметрами))
            }
            array_push($this->modules, $module); // записываем в массив созданые объекты модулей
        }
    }

    public function handleMethod(Module $module, ReflectionMethod $method, $params){ // принимаем следующему методу $module(оозданый обьект модуля, $method(метод модуля в виде ReflectionMethod), $params(массив с параметрами))
        $name = $method->getName(); // имя метода
        $args = $method->getParameters(); // параметры в виде ReflectionParameter

        if(count($args) !=1 or substr($name,0,3) != "set"){ // если количество принимаемых аргументов не равно 1, или название метода не начинается со слов set, то выключать
           return false;
        }


        $property = strtolower(substr($name,3)); // от имени метода отрезаем "set" и получаем имя свойства (host, user и тд)
        if(!isset($params[$property])){ // если в массиве с параметрами нету имени аргумента, которое совпадает с именем свойства, то выключаем
            return false;
        }

        $arg_class = $args[0]->getClass(); // проверяем есть ли класс, обьектом которого должен быть передаваемый аргумент (например setPerson(Person $person))
        if(empty($arg_class)){
            $method->invoke($module,$params[$property]); // если класса нету, то вставляем в метод нашего модуля, просто значение аргумента
        }else{
            $method->invoke($module, $arg_class->newInstance($params[$property])); // если класс есть, но сначала создаём обьект этого класса, в его конструктор передаём значение аргумента, и теперь этот объект передаём в метод
        }
    }

}

$runner = new ModuleRunner();
$runner->init();

echo "</pre>";
