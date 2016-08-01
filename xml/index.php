<?php
echo "<pre>";

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

        createNods($game,$params);

        file_put_contents($sourceFile, $xml->asXML()); // записываем наш объект $xml в xml файл
}

function createNods($game, $params){
    foreach ($params as $key => $val) { // перебираем параметры
        if($game[0]->$key){ // если такой нод есть..
            if(is_array($val)){ // если значение это массив, значит это дочерние ноды...
                createNods($game[0]->$key, $val); // рекурсивно вызываем эту же функцию, но к Xpath ($game[0]) дописываем ->$key, это будет путь к дочернему ноду в который мы запишем $val
            }else{
                $game[0]->$key = $val; // записываем в него значение
            }
        }else{ // если нету...
            if(is_array($val)){  // если значение это массив, значит это будут новые дочерние ноды...
                $game[0]->addChild($key," "); // создаём новый пустой нод
                createNods($game[0]->$key, $val); // а потом записываем в него $val, но передаём Xpath $game[0] вместе с ->$key, это xpath к толькочто созданому ноду
            }else{
                $game[0]->addChild($key, $val); // то создаём его и записываем в него значение
            }
        }
    }
}





$file = "config.xml"; // путь к файлу
$params = ['name' => 'Witcher', "ganre" => "RPG", "developer" => "CD project", "persons" => ["main_hero" => "Geralt", "secondary_hero" => "Ciry","thirdly_heroes" => ["bard" => "Lyutik", "teacher" => "Vesemir", "dwarf" => "Zolton", "spy" => "Roshe"]]]; // параметры
$gameName = "Witcher2"; // имя

writeParams($file,$params,$gameName);
$output = readParams($file);
print $output;

echo "</pre>";