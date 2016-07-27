<?php

// исследования классов класса ReflectionClass

echo "<pre>";
require_once("../index.php");

function classData(ReflectionClass $class){
        $details = '';
        $name = $class->getName();

        if($class->isUserDefined()){
            $details .= "$name -- создан пользователем.<br>";
        }

        if($class->isInternal()){
            $details .= "$name -- это встроеный класс.<br>";
        }

        if($class->isInterface()){
            $details .= "$name -- это интерфейс.<br>";
        }

        if($class->isAbstract()){
            $details .= "$name -- это абстрактный класс.<br>";
        }

        if($class->isFinal()){
            $details .= "$name -- это финальный класс.<br>";
        }

        if($class->isInstantiable()){
            $details .= "$name -- можно создать экземпляр класса.<br>";
        }else{
            $details .= "$name -- нельзя создать экземпляр класса.<br>";
        }

        if($class->isCloneable()){
            $details .= "$name -- можно клонировать.<br>";
        }else{
            $details .= "$name -- нельзя клонировать.<br>";
        }

        return $details;
    }



$prod_class = new ReflectionClass("CDProduct");

echo classData($prod_class);

echo "<pre>";