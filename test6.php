<?php
// Iterator

class ForLoopIterator implements Iterator {
    protected $array = [];
    protected $i = 0;

    function __construct($array){
        $this->array = $array;
        $this->i = 0;
    }

    function rewind(){
        $this->i = 0;
    }

    function valid(){
        return $this->i < count($this->array);
    }

    function next(){
        $this->i++;
    }

    function key(){
        return $this->i;
    }

    function current()
    {
        return $this->array[$this->i];
    }

    function each(){
        $this->rewind();
        while ($this->valid()){
            echo $this->current();
            echo "<br>";
            $this->next();
        }
    }
}

$cars = ['audi','subaru','bmw'];

$iterator = new ForLoopIterator($cars);

$iterator->each();