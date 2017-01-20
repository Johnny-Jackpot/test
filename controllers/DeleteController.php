<?php

class DeleteController {
    private static function isXHR() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }
    private static function pathsIsMatched() {
        $location = $_POST['location'];
        $path = $_POST['path'];

        
    }
    public function actionDelete() {
        if (!self::isXHR()) {
            http_response_code(501);
        }

        


        var_dump($_SERVER);
        var_dump($_REQUEST);
        var_dump($_POST);
        return true;
    }
}