<?php
require_once '../vendor/libs/Dev.php';
require_once '../vendor/core/Router.php';

use vendor\core\Router;

spl_autoload_register(function ($class) {
    $ds = DIRECTORY_SEPARATOR; //підбирає правильний слеш в різних ОС
    $path = str_replace('\\', $ds, $class) . '.php'; //заміна зворотніх слешів на слеші, які використовує конкретна ОС
    debug($path);
    if (file_exists($path)) {
        require $path;
    }
});

echo $query = $_SERVER['QUERY_STRING'];


$route = new Router();
$route->add('posts/post', ['controller' => 'posts', 'action' => 'post']);
$route->add('posts/car', ['controller' => 'posts', 'action' => 'car']);
$route->add('posts/food', ['controller' => 'posts', 'action' => 'food']);
$route->add('posts/phone', ['controller' => 'posts', 'action' => 'phone']);

if ($route->matchRoute($query)){
    debug($route->getRoute());
}else{
    echo '404';
}
//debug($route->getRoutes());