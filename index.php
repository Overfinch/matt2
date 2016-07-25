<?php

// Добавил commit через Github Desctop



interface Chargable{
    public function getPrice();
}

class ShopProduct implements Chargable{
    private $id;
    private $title;
    private $producerMainName;
    private $producerFirstName;
    protected $price;
    private $discount = 0;

    public function __construct($title, $producerMainName, $producerFirstName, $price){
        $this->title = $title;
        $this->producerMainName = $producerMainName;
        $this->producerFirstName = $producerFirstName;
        $this->price = $price;
    }

    public function setID($id){
        $this->id = $id;
    }

    public function setDiscount($num){
        $this->discount = $num;
    }

    public function getDiscount(){
        return $this->discount;
    }

    public function getPrice(){
        return ($this->price - $this->discount);
    }

    public function getProducer(){
        return $this->producerFirstName." ".$this->producerMainName;
    }

    public function getProducerFirstName(){
        return $this->producerFirstName;
    }

    public function getProducerMainName(){
        return $this->producerMainName;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getSummaryLine(){
        $base = $this->title." (".$this->producerFirstName." ".$this->producerMainName.")";
        return $base;
    }

    public static function getInstance($id, PDO $pdo){ // Статический метод, который создаёт объект из даннх из БД
        $stms = $pdo->prepare("SELECT * FROM products WHERE id=?");
        $result = $stms->execute(array($id));

        $row = $stms->fetch();

        if(empty($row)){
            return null;
        }

        if($row['type'] == "book"){ // проверяем "тип"
            $product = new BookProduct( $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['numpages']);
        }else if($row['type'] == "cd"){ // проверяем "тип"
            $product = new CDProduct(   $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['playlength']);
        }else{ // если неизвесный "тип", то применяем родительский класс ShopProduct
            $product = new ShopProduct( $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price']);
        }

        $product->setID($row['id']);
        $product->setDiscount($row['discount']);
        return $product; // возвращаем готовый объект
    }
}

class CDProduct extends ShopProduct {
    private $playLength;

    public function __construct($title, $producerMainName, $producerFirstName, $price, $playLength){
        parent::__construct($title, $producerMainName, $producerFirstName, $price);
        $this->playLength = $playLength;
    }

    public function getPlayLength(){
        return $this->playLength;
    }

    public function __iterator_to_array(){
        return '123';
    }

    public function getSummaryLine(){
        $base = parent::getSummaryLine();
        $base .= " Время звучания: ".$this->playLength;
        return $base;
    }
}

class BookProduct extends ShopProduct {
    public $numPages;

    public function __construct($title, $producerMainName, $producerFirstName, $price, $numPages){
        parent::__construct($title, $producerMainName, $producerFirstName, $price);
        $this->numPages = $numPages;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getNumPages(){
        return $this->numPages;
    }

    public function getSummaryLine(){
        $base = parent::getSummaryLine();
        $base .= " Количество страниц: ".$this->numPages;
        return $base;
    }
}

abstract class ShopProductWriter {
    protected $products = [];

    public function addProduct(ShopProduct $product){
        $this->products[] = $product;
    }

    abstract public function write();
}

class XMLProductWriter extends ShopProductWriter {
    public function write(){
        $str = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
        $str .= "<products>";
        foreach($this->products as $shopProduct){
            $str .= "<product title=\"{$shopProduct->getTitle()}\">";
            $str .= "<summary>";
            $str .= $shopProduct->getSummaryLine();
            $str .= "</summary>";
            $str .= "</product>";
        }
        $str .= "</products>";
        return $str;
    }
}

class TextProductWriter extends ShopProductWriter {
    public function write(){
        $str = "Товары: ";
        foreach($this->products as $shopProduct){
            $str .= $shopProduct->getSummaryLine();
        }
        return $str;
    }
}



$pdo = new PDO('mysql:host=localhost;dbname=matt2','root',''); // инициализируем PDO

$product1 = new CDProduct("Harakiri", "Tankian", "Serj", 100, 90); // создали объект вручную
$product2 = new BookProduct("Пикник на обочине", "Стругацкий", "Борис", 200, 300); // создали объект вручную
$product3 = ShopProduct::getInstance(1,$pdo); // создали объект статическим методом, достав данные из БД

$writer = new TextProductWriter(); // создаём нового writer`а
$writer->addProduct($product1); // добавляем в него объект

echo $writer->write(); // выводим информацию про объект добавленный в наш writer
echo "<br>";
echo $product2->getSummaryLine();
echo "<br>";
echo $product3->getSummaryLine();
echo "<hr>";
