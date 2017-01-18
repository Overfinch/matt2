<?php

class RequestHelper {}

abstract class ProcessRequest {
    abstract function process(RequestHelper $req);
}

class MainProcess extends ProcessRequest {
    function process(RequestHelper $req){
        print __CLASS__." Выполнение запроса <br>";
    }
}

abstract class DecorateProcess extends ProcessRequest {
    protected $processRequest;

    function __construct(ProcessRequest $processRequest) {
        $this->processRequest = $processRequest;
    }
}

class LogRequest extends DecorateProcess {
    function process(RequestHelper $req){
        print __CLASS__." Регистрация запроса <br>";
        $this->processRequest->process($req);
    }
}

class AuthenticateProcess extends DecorateProcess {
    function process(RequestHelper $req){
        print __CLASS__." Аутентификация запроса <br>";
        $this->processRequest->process($req);
    }
}

class StructureRequest extends DecorateProcess {
    function process(RequestHelper $req){
        print __CLASS__." Упорядочение данных запроса <br>";
        $this->processRequest->process($req);
    }
}

$req = new RequestHelper();

$process = new StructureRequest(new AuthenticateProcess(new LogRequest(new MainProcess())));
$process->process($req);

// Декоратор на примепе фильтров к запросу, мы можем комбинировать очерёдность декораторов.