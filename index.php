<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

define('ROOT', dirname(__FILE__));
define('GALLERY', 'gallery');
define('APP', ROOT . '/app');
require_once ROOT . '/components/Autoload.php';

$router = new Router();
$router->run();

/*
    Main goal of this app is to show images ))
*/
function show($template, $view, $data) {
    @extract($data);
    require($template);
}