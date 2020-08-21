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
//            якщо співпадіння було знайдено
            if ($url == $pattern){
                $this->route = $route; // то записується поточний маршрут
                return true;
            }
        }
        return false;
    }
}