<?php

trait PathCheck {
    /*
        Path to file we need delete stored in data-path attr
        we need compare that attr with actual route 
        ( i.e. http://localhost/gallery/path/to/folder with 
                data-path="gallery/path/to/folder/image.png")
        @param string $path
        @return bool
    */
    public function pathsIsMatched($path) {
        $HTTP_ORIGIN = $_SERVER['HTTP_ORIGIN'];
        $route = preg_replace("~$HTTP_ORIGIN~", '', $_SERVER['HTTP_REFERER']);
        $pathArr = explode('/', $path);
        array_pop($pathArr);

        return $route === implode('/', $pathArr);
    }
}