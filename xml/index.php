<?php


function readParams($sourceFile){ // вывод содержимого XML
        $xml = simplexml_load_file($sourceFile);
        return $xml->asXML();
}

function writeParams($sourceFile, $params, $gameName){

        $xml = simplexml_load_file($sourceFile); // создаём SimpleXMLElement объект из нашего xml
        $game = $xml->xpath("/list/games/game[@name=\"$gameName\"]"); // записываем в $game xpath к искомому ноду
        if(!$game){ // если такого нода нету...
            $xml->games[0]->addChild("game", " ")->addAttribute("name",$gameName); // создаём его
            $game = $xml->xpath("/list/games/game[@name=\"$gameName\"]"); // и записываем его xpath
        }

        foreach ($params as $key => $val) { // перебираем параметры
            if($game[0]->$key){ // если такой нод есть..
                $game[0]->$key = $val; // записываем в него значение
            }else{ // если нету...
                $game[0]->addChild($key, $val); // то создаём его и записываем в него значение
            }
        }

        file_put_contents($sourceFile, $xml->asXML()); // записываем наш объект $xml в xml файл
}





$file = "config.xml"; // путь к файлу
$params = ['name' => 'Witcher', "ganre" => "RPG", "developer" => "CD project"]; // параметры
$gameName = "Witcher"; // имя

writeParams($file,$params,$gameName);
$output = readParams($file);
print $output;
