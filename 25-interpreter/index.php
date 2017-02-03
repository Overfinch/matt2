<?php

abstract class Expression { // абстрактный класс всех эллементов
    private static $keycount = 0; // статичное свойство, не обнуляется, оно общае для всех объектов которые наследуют это класс
    private $key;

    abstract function interpret(InterpreterContext $context); // взаимодействие с InterpreterContext (хранилищем данных)

    function getKey(){
        if(!isset($this->key)){
            self::$keycount++;
            $this->key = self::$keycount;
        }
        return $this->key;
    }
}

class LiteralExpression extends Expression { // строка
    private $value;

    function __construct($value){
        $this->value = $value;
    }

    function interpret(InterpreterContext $context){ // сохранение в хранилище
        $context->replace($this, $this->value);
    }
}

class VariableExpression extends Expression { // переменная
    private $name;
    private $val;

    function __construct($name,$val = null){
        $this->name = $name;
        $this->val = $val;
    }

    function interpret(InterpreterContext $context){ // сохранение вхранилище
        if(!is_null($this->val)){
            $context->replace($this,$this->val);
            $this->val = null;
        }
    }

    function setValue($value){
        $this->val = $value;
    }

    function getKey(){
        return $this->name;
    }
}

class InterpreterContext { // хранилище данных
    private $expressionstore = [];

    function replace(Expression $exp, $value){
        $this->expressionstore[$exp->getKey()] = $value;
    }

    function lookup(Expression $exp){
        return $this->expressionstore[$exp->getKey()];
    }
}

abstract class OperatorExpressions extends Expression { // абстрактный класс логических операторов
    protected $l_op;
    protected $r_op;

    function __construct(Expression $l_op, Expression $r_op){ // аргументы которые принимает логический оператор
        $this->l_op = $l_op;
        $this->r_op = $r_op;
    }

    function interpret(InterpreterContext $context){
        $this->l_op->interpret($context); // добавляет оба аргумента в хранилиже
        $this->r_op->interpret($context);
        $result_l = $context->lookup($this->l_op); // достаём значение аргументов
        $result_r = $context->lookup($this->r_op);
        $this->doInterpret($context, $result_l, $result_r);
    }

    abstract function doInterpret(InterpreterContext $context, $result_l, $result_r);
}

class EqualsExpression extends OperatorExpressions { // проверяется равенство, возвращает true/false
    function doInterpret(InterpreterContext $context, $result_l, $result_r){
        $context->replace($this, $result_l == $result_r);
    }
}

class BooleanOrExpression extends OperatorExpressions { // ИЛИ
    function doInterpret(InterpreterContext $context, $result_l, $result_r){
        $context->replace($this, $result_l || $result_r);
    }
}

class BooleanAndExpression extends OperatorExpressions { // И
    function doInterpret(InterpreterContext $context, $result_l, $result_r){
        $context->replace($this, $result_l && $result_r);
    }
}

$context = new InterpreterContext();
$input = new VariableExpression('input'); // переменная input (пока без значения)
$statement = new BooleanOrExpression( // OR
    new EqualsExpression($input, new LiteralExpression('четыре')),
    new EqualsExpression($input, new LiteralExpression('4'))
);

foreach (['четыре','4', '42'] as $val){ // массив со значениями
    $input->setValue($val); //перебераем массив
    print $val."<br>";
    $statement->interpret($context);
    if ($context->lookup($statement)){ // возвращает булевый ответ на логическую операцию сравнения
        print "Соответствует <hr>";
    }else{
        print "Не соответствует <hr>";
    }
}
