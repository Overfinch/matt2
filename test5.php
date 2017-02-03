<?php

function foo() {
    static $a = 0;
    echo $a;
    $a = $a + 1;
}

foo(); // 0
foo(); // 1
foo(); // 2
