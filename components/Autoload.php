<?php

spl_autoload_register(function ($className) {
    $arrPaths = [
        '/models/',
        '/components/',
        '/controllers/',
        '/traits/'
    ];
    
    foreach ($arrPaths as $path) {
        $path = ROOT . $path . $className . '.php';
        require_once($path);        
    }
});