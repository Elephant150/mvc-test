<?php

define('WWW' , __DIR__);
define('CORE' , dirname(__DIR__) . '/vendor/core');
define('ROOT' , dirname(__DIR__));
define('APP' , dirname(__DIR__) . '/application');

require_once '../vendor/libs/Dev.php';
require_once '../vendor/core/Router.php';
//require_once  '../application/controllers/Posts.php';
//require_once  '../application/controllers/PostNew.php';
//require_once  '../application/controllers/Main.php';

use vendor\core\Router;

//spl_autoload_register(function ($class) {
//    $ds = DIRECTORY_SEPARATOR; //підбирає правильний слеш в різних ОС
//    $path = str_replace('\\', $ds, $class) . '.php'; //заміна зворотніх слешів на слеші, які використовує конкретна ОС
//    debug($path);
//    if (file_exists($path)) {
//        require $path;
//    }
//});

spl_autoload_register(function ($class){
    $file =  APP . "/controllers/$class.php";
    if (is_file($file)){
        require_once $file;
    }
});

echo $query = $_SERVER['QUERY_STRING'];


$route = new Router();

//my routs
$route->add('^test/?(?P<action>[a-z-]+)?$', ['controller' => 'Main']);

//default routs
$route->add('^$', ['controller' => 'posts', 'action' => 'index']);
$route->add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

debug($route->getRoutes());

$route->dispatch($query);
