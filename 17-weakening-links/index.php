<?php

// Ослабление связей

class Config{ // имитируем файл конфигураций
    static function getConfig(){
        return 1;
    }
}
class Lesson{}

class GetRegistrationMgr{
    function registerLesson(Lesson $lesson){
        // что-то делаем с Lesson
        // отправляем сообщение о регистрации
        $notifier = Notifier::getNotifier(); // этот класс даже не будет знать каким классом будет реализована отправка
        $notifier->inform();
    }
}

abstract class Notifier { // если нам понадобится добавить новые методы рассылки, мы просто создадим их классы и добавим сюда, класс GetRegistrationMgr даже не будет знать какие классы существуют
    static function getNotifier(){
        // Создаём объект нужного класса, согласно файлу конфигураций (или другой логики)
        if(Config::getConfig() == 1){
            return new TextNotifier();
        }else{
            return new MailNotifer();
        }
    }
}

class MailNotifer extends Notifier {
    public function inform(){
        print "Отправлено по почте";
    }
}

class TextNotifier extends Notifier{
    public function inform(){
        print "Отправлено по текстом";
    }
}

$lesson1 = new Lesson();
$register = new GetRegistrationMgr();
$register->registerLesson($lesson1);
