<?php

// Процедурный подход
// Мы проверяем расширение файла в каждой функции

// если нам понадобится внести новый формат, то мы должны будем внести соответствующиие изменения в каждую функцию

echo "<pre>";

function readParams($sourceFile){
    $ext = new SplFileInfo($sourceFile);
    $ext = $ext->getExtension();
    if ($ext == 'txt'){
        $params = file_get_contents($sourceFile);
        return $params;
    }elseif ($ext == "xml"){
        $xml = simplexml_load_file($sourceFile);
        return $xml->asXML();
    }
}

function writeParams($sourceFile, $params){

    $ext = new SplFileInfo($sourceFile);
    $ext = $ext->getExtension();

    if ($ext == 'txt'){
        $str = '';
        foreach ($params as $key => $val){
            $str .= "$key - $val <br>";
        }
        file_put_contents($sourceFile,$str);
    }elseif ($ext == "xml") {
        $xml = simplexml_load_file($sourceFile);
        foreach ($params as $key => $val) {
            if($xml->persons[0]->$key){
                $xml->persons[0]->$key = $val;
            }else{
                $xml->persons[0]->addChild($key, $val);
            }
        }
        file_put_contents($sourceFile, $xml->asXML());
    }

}





$file = "params.xml";
$params = ['name' => 'Sidodge1', "age" => "23", "color" => "black", "gang" => "grove"];

writeParams($file,$params);
$output = readParams($file);
print $output;

echo "</pre>";