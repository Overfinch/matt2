<?php

// __clone

class Account {
    public $balance;

    public function __construct($balance){
        $this->balance = $balance;
    }
}

class Person {
    public $name;
    public $age;
    public $id;
    public $account;

    public function __construct($name, $age, Account $account){
        $this->name = $name;
        $this->age = $age;
        $this->account = $account;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function __clone(){ // вызывается при клонировании обьекта,
        $this->id = 0; // все изменения применяются только к новому(клонированому) обьекту
        $this->account = clone $this->account; // так же клонируем обьект класса аккаунт, что бы новый(клонированый) обьект(Person) не ссылался на старый(Account)
    }
}


$account = new Account(100);
$person = new Person("Ivan", 44, $account);
$person->setId(12);
$person2 = clone $person;

echo $person->id;
echo "<br>";
echo $person2->id;