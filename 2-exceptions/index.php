<?php

echo "<pre>";

class XMLException extends Exception {
    private $error;

    public function __construct(LibXMLError $error)
    {
        var_dump($this->error);
        $shortfile = basename($error->file);
        $msg = "[".$shortfile." строка ". $error->line.", ";
        $msg .= "колонка ".$error->column."] ".$error->message;
        $this->error = $error;
        parent::__construct($msg, $error->code);
    }

    public function getLibXMLError(){
        return $this->error;
    }
}

class FileException extends Exception{}
class ConfException extends Exception{}

class Conf {
    private $file;
    private $xml;
    public $lastmatch;


    public function __construct($file){
        $this->file = $file;

        if(!file_exists($file)){
            throw new FileException("файл ".$this->file." не существует");
        }

        $this->xml = simplexml_load_file($file);
        if(!is_object($this->xml)){
            throw new XMLException(libxml_get_last_error());
        }

        $matches = $this->xml->xpath("/conf");
        if(!count($matches)){
            throw new ConfException("Корневой элемен conf не найден");
        }
    }

    public function get($str){
        $matches = $this->xml->xpath("/conf/item[@name=\"$str\"]");
        if(count($matches)){
            $this->lastmatch = $matches[0];
            return (string)$matches[0];
        }
        return null;
    }

    public function set($key,$value){
        if(! is_null($this->get($key))){
            $this->lastmatch[0] = $value;
            return;
        }
        //$this->xml->addChild('item', $value)->addAttribute('name', $key);
    }

    public function write(){
        if(!is_writable($this->file)){
            throw new Exception("файл ".$this->file." не доступен для записи");
        }
        file_put_contents($this->file, $this->xml->asXML());
    }
}


try{
    $conf = new Conf('conf.xml');
    $conf->set('new', 1);
    $conf->write();
}catch (FileException $e){
    die($e->__toString());
}catch (XMLException $e){
    die($e->__toString());
}catch (ConfException $e){
    die($e->__toString());
}catch (Exception $e){
    die($e->__toString());
}




echo "</pre>";