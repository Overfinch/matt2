<?php

class ShpoProduct{}

function getProduct(){
    return new ShpoProduct();
}

$product = getProduct();

if($product instanceof ShpoProduct){ // проверяем является ли обьект, экземпляром класса ShopProduct
    print "Объект класса ShopProduct";
}