<?php
require_once 'application/lib/Dev.php';

use application\lib\Test;

spl_autoload_register(function ($class) {
    $ds = DIRECTORY_SEPARATOR; //підбирає правильний слеш в різних ОС
    $path = str_replace('\\', $ds, $class) . '.php'; //заміна зворотніх слешів на слеші, які використовує конкретна ОС

    if (file_exists($path)) {
        require $path;
    }
});

$test = new Test();