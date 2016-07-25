<?php

require_once("../index.php");

$reflection = new ReflectionClass("CDProduct"); // создаём обьект класса ReflectionClass с классом Person

echo "<pre>";
Reflection::export($reflection); // Reflection::export() выводит сведения
echo "</pre>";
