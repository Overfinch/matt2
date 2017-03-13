<?php
//В основе шаблона Observer лежит принцип отсоединения клиентских элементов (наблюдателей) от центрального класса (субъекта).
// Наблюдатели должны быть проинформированы, когда происходят события, о которых знает субъект

interface Observable {
    function attach(Observer $observer);
    function detach(Observer $observer);
    function notify();
}

interface Observer {
    function update(Observable $observable);
}

abstract class LoginObserver implements Observer {
    private $login;

    function __construct(Login $login){ // наблюдатель сам "заклепляется" за объектомЮ при создании
        $this->login = $login;
        $login->attach($this);
    }

    function update(Observable $observable){
        if($observable === $this->login){
            $this->doUpdate($observable);
        }
    }

    abstract function doUpdate(Login $login);
}

class Login  implements Observable { // объект за которым будут наблюдать наблюдатели
    private $observers = [];

    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_ACCESS = 3;
    private $status = [];

    function __construct(){
        $this->observers = [];
    }

    function attach(Observer $observer){ // прикрепляем наблюдателя к объекту
        $this->observers[] = $observer;
    }

    function detach(Observer $observer){ // открепляем наблюдателья от объекта
        $this->observers = array_filter($this->observers,
            function ($a) use ($observer){
                return(!($a === $observer));
            }
        );
    }

    function notify(){ // вызываем метод update() у всех наблюдателей
        foreach ($this->observers as $obs){
            $obs->update($this);
        }
    }

    function handleLogin($user, $pass, $ip){
        $isValid = false;
        switch (rand(1,3)){ // иммитируем проверку учетных данных пользователя
            case 1:
                $this->setStatus(self::LOGIN_ACCESS, $user, $ip);
                $isValid = true;
                break;
            case 2;
                $this->setStatus(self::LOGIN_WRONG_PASS, $user, $ip);
                $isValid = false;
                break;
            case 3;
                $this->setStatus(self::LOGIN_USER_UNKNOWN, $user, $ip);
                $isValid = false;
                break;
        }
        $this->notify();
        return $isValid;
    }

    function setStatus($status, $user, $ip){
        $this->status = [$status, $user, $ip];
    }

    function getStatus(){
        return $this->status;
    }
}

class SecurityMonitor extends LoginObserver { // наблюдатель
    function doUpdate(Login $login){
        $status = $login->getStatus();
        if ($status[0] == Login::LOGIN_WRONG_PASS){
            // Отправим почту системному администратору
            print __CLASS__." Отправка почты системному администратору<br>";
        }
    }
}

class GeneralLogger extends LoginObserver { // наблюдатель
    function doUpdate(Login $login){
        $status = $login->getStatus();
        // Регистрируем подключение в журнале
        print __CLASS__." Регистрация в системном журнале <br>";
    }
}

class PartnershipTool extends LoginObserver { // наблюдатель
    function doUpdate(Login $login){
        $status = $login->getStatus();
        // отправим cookie файл если адрес соответствует списку
        print __CLASS__." Отправка cookie файла, если адрес соответствует списку <br>";
    }
}

$login = new Login(); // объект за которым будут наблюдать наблюдатели
$securityMonitor = new SecurityMonitor($login); // наблюдатель
$generalLogger = new GeneralLogger($login); // наблюдатель
$partnershipTool = new PartnershipTool($login); // наблюдатель
$login->handleLogin('','','');
