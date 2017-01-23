<?php

class DeleteController {
    private function isXHR() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }

    /*
        Path to file we need delete stored in data-path attr
        we need compare that attr with actual route 
        ( i.e. http://localhost/gallery/path/to/folder with 
                data-path="gallery/path/to/folder/image.png")
        @param string $path
        @return bool
    */
    private function pathsIsMatched($path) {
        $HTTP_ORIGIN = $_SERVER['HTTP_ORIGIN'];
        $route = preg_replace("~$HTTP_ORIGIN~", '', $_SERVER['HTTP_REFERER']);
        $pathArr = explode('/', $path);
        array_pop($pathArr);

        return $route === implode('/', $pathArr);
    }
    public function actionDelete() {
        if (!$this->isXHR() || !$this->pathsIsMatched($_POST['path'])) {
            http_response_code(501);
        }
        
        /*$result = Gallery::deleteItem($path);
        
        if ($result)
            http_response_code(200);
        else
            http_response_code(500);*/
            http_response_code(200);
        
        return true;
    }
}