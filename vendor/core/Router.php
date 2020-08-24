<?php

namespace vendor\core;

class Router
{
    protected $routes = []; //таблиця маршрутів
    protected $route = []; //поточний маршрут

//    дбавляє маршрути
    public function add($regexp, $route = [])
    {
        $this->routes[$regexp] = $route;
    }

//    допоміжний метод для розпечатки маршрутів
    public function getRoutes()
    {
        return $this->routes;
    }

//    повертає поточний маршрут з яким працює програма
    public function getRoute()
    {
        return $this->route;
    }

//    шукає співпадіння з запитом в таблиці маршрутів
    public function matchRoute($url)
    {
        foreach ($this->routes as $pattern => $route) {

            if (preg_match("#$pattern#i", $url, $matches)) {

                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }

                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }

                $this->route = $route; // записується поточний маршрут
                return true;
            }
        }
        return false;
    }

    /**
     * перенаправляє URL по коректному маршруту
     * @param string $url вхідний URL
     * @return void
     */
    public function dispatch($url)
    {
        if ($this->matchRoute($url)) {
            $controller = 'application\controllers\\' . $this->upperCamelCase($this->route['controller']);

            if (class_exists($controller)) {
                $controllerObject = new $controller;
                $action = $this->lowerCamelCase($this->route['action']) . 'Action';
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    echo "Method <strong>$controller->$action</strong> not found!";
                }
            } else {
                echo "Class <strong>$controller</strong> not found!";
            }
        } else {
            include '../public/404.html';
        }
    }

    public function upperCamelCase($name)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    public function lowerCamelCase($name)
    {
        return lcfirst($this->upperCamelCase($name));
    }
}