<?php


namespace vendor\core\base;


class View
{
    public $route = []; //даний маршрут і параметри (controller, action, params)
    public $view; // даний вид
    public $layout; // даний шаблон

    public function __construct($route, $view = '', $layout = '')
    {
        $this->route = $route;

        // якщо layout = false то присвоїти layout = false (тобіш не загружати макет)
        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view = $view;
    }

    public function render()
    {
        $file_view = APP . "/views/{$this->route['controller']}/{$this->view}.php";
        ob_start();
        if (is_file($file_view)) {
            require $file_view;
        } else {
            echo "<p>View <strong>$file_view</strong> not found!</p>";
        }
        $content = ob_get_clean();

        if (false !== $this->layout) {
            $file_layout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($file_layout)) {
                require $file_layout;
            } else {
                echo "<p>Layout <strong>$file_layout</strong> not found!</p>";
            }
        }
    }
}