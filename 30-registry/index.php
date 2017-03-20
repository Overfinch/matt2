<?php
// ПРИМЕР НЕ ИЗ КНИГИ

//  Registry — это ООП замена глобальным переменным, предназначеная для хранения данных и передачи их между модулями системы.
// Соответственно, его наделяют стандартными свойствами — запись, чтение, удаление. Вот типовая реализация.

class Registry {
    static protected $data; // массив с эллементами
    static protected $lock = []; // массив с ключами эллементов которые заблокированы для записи

    static public function set($key, $val){ // устанавливает значение по $key
        if(!self::hasLock($key)){
            self::$data[$key] = $val;
        }else{
            print "Переменная $key заблокирована для изменений";
        }
    }

    static public function get($key, $default = null){ // возвращает значение по $key
        if (self::has($key)){
            return self::$data[$key];
        }else{
            return $default;
        }
    }

    static public function remove($key){ // удаляет значение по $key
        if (self::has($key) && self::hasLock($key)){
            unset(self::$data[$key]);
        }
    }

    static protected function has($key){ // проверяет наличие ключа
        return isset(self::$data[$key]);
    }

    static public function lock($key){ // устанавливает блокировку по ключу
        self::$lock[$key] = true;
    }

    static protected function hasLock($key){ // проверяет блокировку по ключу
        return isset(self::$lock[$key]);
    }

    static public function unsetLock($key){ // удаляет блокировку по ключу
        if (self::hasLock($key)){
            unset(self::$lock[$key]);
        }
    }
}

Registry::set('color','red');   // устанавливаем новое значение
print Registry::get('color');
Registry::set('color','blue');  // устанавливаем новое значени
print Registry::get('color');
Registry::lock('color');        // устанавливаем блокировку
Registry::set('color','yellow');// устанавливает значение (не устанавливается так как мы заблокировали 'color')
Registry::unsetLock('color');   // убираем блокировку
Registry::set('color','green'); // устанавливаем новое значение
print Registry::get('color');