<?php


namespace vendor\core\base;


abstract class Controller
{
    public $route = [];
    public $view;
    public $layout;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $route['action'];
//        include APP . "/views/{$route['controller']}/{$this->views}.php";
    }

    public function getView()
    {
        $viewObject = new View($this->route, $this->view, $this->layout);
        $viewObject->render();
    }
}