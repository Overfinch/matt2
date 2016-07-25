<?php

$a = new stdClass();
$a->foo = new stdClass();
$a->foo->bar = 123;

$x = new stdClass();
$x->z = $a->foo;
$x->z->bar = 456;

$u = $a->foo;

echo $a->foo->bar; // что выведет?

echo "<pre>";
var_dump($a);
var_dump($x);
var_dump($u);
echo "</pre>";