<?php

ini_set('display_errors', 1); // вивід помилок на екран
error_reporting(E_ALL); //звіт про помилки

//debug - для невеликих перевірок під час написання коду
function debug($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
//    exit();
}







