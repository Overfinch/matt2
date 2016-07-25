<?php

// Получаем полные имена классов с их пространствами имён

namespace mypackagege;

use util as u;
use util\db\Querier as q;

class Local{}

print u\Writer::class; // выведет util\Writer
print "<br>";
print q\Writer::class; // выведет util\db\Querier\Writer
print "<br>";
print Local::class; // выведет mypackege\Writer