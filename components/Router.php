<?php

class Router {
    private $routes;
    
    public function __construct() {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }
    
    private function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            
            $uri = trim($_SERVER['REQUEST_URI'], '/');
            return explode('?', $uri)[0];
             
        }
    }

    /*
        Every action must return true in order to stop router iteration over routes
    */
    public function run() {
        $uri = $this->getURI();        
        
        foreach ($this->routes as $uriPattern => $path) {
            /**
            **  preg_match return true if $uriPattern === 'any string' &&
            **  $uri === '' (empty string)
            */
            if (!preg_match("~$uriPattern~", $uri)) continue;                                    
                
            $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
            /*echo '$internalRoute:';
            var_dump($internalRoute);*/
            $segments = explode('/', $internalRoute);
            /*echo '$segments:';
            var_dump($segments);*/
            $controllerName = array_shift($segments) . 'Controller';
            $controllerName = ucfirst($controllerName);
            $actionName = 'action' . ucfirst(array_shift($segments));
            $parameters = $segments; 
            /*echo '$parameters:';
            var_dump($parameters);*/
            $controllerFile = ROOT . '/controllers/' . 
                    $controllerName . '.php';
            
            if(!file_exists($controllerFile)) continue;
            
            include_once($controllerFile);
            
            if (!method_exists($controllerName, $actionName)) continue;

            $controllerObject = new $controllerName;
            $result = call_user_func_array(
                        array($controllerObject, $actionName),                           
                        $parameters
                    );
            
            if ($result != null) return;
            
        }

        http_response_code(404);
        show(ROOT . '/template/php/error.php', ROOT . '/views/404.php', null);
    }
}