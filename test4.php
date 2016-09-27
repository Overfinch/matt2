<?php

function fibo($limit){
    $temp1 = 1;
    $temp2 = 0;
    for ($i=0; $i<$limit; $i++){
        $result = $temp1 + $temp2;
        print $result."<br>";
        $temp2 = $temp1;
        $temp1 = $result;
    }
}

fibo(10);