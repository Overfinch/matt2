<?php

$classname = "Task";

require_once($classname.".php");

$classname = "tasks\\".$classname;

$myObj = new $classname();
$myObj->doSpeak();