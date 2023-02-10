<?php

spl_autoload_register(function ($class_name) {
    $class = strtolower($class_name);

    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if (strpos($url, 'includes') !== false) {
        $inc = '../classes/';
    } else {
        $inc = 'classes/';
    }

    $path = $inc . $class . ".class.php";

    if (!file_exists($path)) {
        return false;
    }

    include $path;
});