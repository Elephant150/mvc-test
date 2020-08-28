<?php

use vendor\core\Router;

$query = $_SERVER['QUERY_STRING'];

require_once '../vendor/libs/Dev.php';

//require_once '../application/controllers/DatabaseShell.php';

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/application');
define('LAYOUT', 'default');

spl_autoload_register(function ($class) {
    $ds = DIRECTORY_SEPARATOR; //підбирає правильний слеш в різних ОС
    $file = ROOT . '/' . str_replace('\\', $ds, $class) . '.php'; //заміна зворотніх слешів на слеші, які використовує конкретна ОС

    if (is_file($file)) {
        require_once $file;
    }
});

$route = new Router();

$route->add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Page']);
$route->add('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action' => 'views']);

//default routs
$route->add('^$', ['controller' => 'Main', 'action' => 'index']);
$route->add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

//debug($route->getRoutes());

$route->dispatch($query);


