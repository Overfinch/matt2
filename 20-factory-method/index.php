<?php

// Реализация шаблона Factory Method и Abstract Factory

abstract class ApptEncoder {
    abstract function encode();
}

class BlogsApptEncoder extends ApptEncoder {
    function encode(){
        return "Данные о встрече закодированы в формате BlogsCall <br>";
    }
}

class MegaApptEncoder extends ApptEncoder {
    function encode(){
        return "Данные о встрече закодированы в формате MegaCall <br>";
    }
}

/*------------------------------------------------------------------------------*/

abstract class ContactEncoder {
    abstract function encode();
}

class BlogsContactEncoder extends ContactEncoder {
    function encode(){
        return "Данные о контактах закодированы в формате BlogsCall";
    }
}

class MegaContactEncoder extends ContactEncoder {
    function encode(){
        return "Данные о контактах закодированы в формате Megacall";
    }
}

/*------------------------------------------------------------------------------*/

abstract class CommsManager { // абстрактный класс фабрики
    abstract function getHeaderText();
    abstract function getFooterText();
    /* Здесь описан Factory Method (методы которые создадут экземпляры нужных классов) */
    abstract function getApptEncoder();
    abstract function getContactEncoder();
    /*---------------------------------------------------------------------------------*/
}

class BlogsCommsManager extends CommsManager { // реализация одной из фабрик
    function getHeaderText(){
                return "BlogsCall верхний колонтикул <br>";
    }

    function getFooterText(){
        return "BlogsCall нижний колонтикул <br>";
    }

    function getApptEncoder(){
        return new BlogsApptEncoder();
    }

    function getContactEncoder(){
        return new BlogsContactEncoder();
    }
}

class MegaCommsManager extends CommsManager { // реализация одной из фабрик
    function getHeaderText(){
        return "MegaCall верхний колонтикул <br>";
    }

    function getFooterText(){
        return "MegaCall нижний колонтикул <br>";
    }

    function getApptEncoder(){
        return new MegaApptEncoder();
    }

    function getContactEncoder(){
        return new MegaContactEncoder();
    }
}

// Если нам надо будет добавить новые дочерние классы для CommsManager или ApptEncoder
// то мы их просто допишем, а клиентский код, уже будет готов принять их,
// так как в абстрактных классах (CommsManager и ApptEncoder) описаны методы, и клиентский код
// будет знать как с ними работать, ему не нужно знать какой именно дочерний класс он обрабатывает
// главное что он наследует абстрактные классы, и можно создавать много дочерних классов, не меняя при это клиентский код

$blogManager = new BlogsCommsManager();
print $blogManager->getHeaderText();
print $blogManager->getFooterText();
print $blogManager->getApptEncoder()->encode();
print $blogManager->getContactEncoder()->encode();// тут мы получаем объект типа ApptEncoder или его наследников
                                                // (в данном случае BlogsApptEncoder), нам не обязательно знать какой именно
                                                // подкласс будет веозвращен, главное что мы уверены что он наследник ApptEncoder
                                                // в дальнейшем мы можем добавить новые дочерние классы которые будут расширять ApptEncoder
                                                // но тут ничего менять не придётся

