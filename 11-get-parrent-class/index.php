<?php

interface SomeInterface{}
class ShopProduct implements SomeInterface{}
class CDProduct extends ShopProduct{}



print get_parent_class("CDProduct"); // проверяем есть ли у класса, классы наследниеки

echo "<br>";

if(is_subclass_of("CDProduct","ShopProduct")){ // проверяет является ли класс, подклассом дргугого класса
    echo "CDproduct является подклассом ShopProduct";
}

echo "<br>";

if(in_array("SomeInterface", class_implements("ShopProduct"))){ // проверяет имплементироует ли класс определённый интерфейс
    echo "класс ShopProduct наследует интерфейс SomeInterface";
}