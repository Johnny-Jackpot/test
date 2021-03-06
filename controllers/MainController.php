<?php

class MainController {
    /*
        Path to file we need delete stored in data-path attr
        we need compare that attr with actual route 
        ( i.e. http://localhost/gallery/path/to/folder with 
                data-path="gallery/path/to/folder/image.png")
        @param string $path
        @return bool
    */
    public function pathsIsMatched($path) {
        $httpHost = $_SERVER['HTTP_HOST'];
        $httpReferer = urldecode( $_SERVER['HTTP_REFERER']);
        $delim = '+';
        $route = preg_replace("~$httpHost~", $delim, $httpReferer);
        $route = explode($delim, $route)[1];
        $pathArr = explode('/', $path);
        array_pop($pathArr);

        return $route === implode('/', $pathArr);
    }

    public function isXHR() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }

    public function actionRedirectToGallery() {
        header("Location: /gallery");
        return true;
    }
    /*
        Main action for render content of gallary (folder or image)
        @param array of variable length (splitted path) 
    */
    public function actionRead() {        
        $path = ''; 
        $items; 
        $folders; 
        $gallery = new Gallery();
        
        if (!func_num_args()) {
            //load root folder of gallery
            $items = $gallery->getItem(APP);
        } else {
            $folders = func_get_args();
            $path = '/' . implode('/', $folders);
            $items = $gallery->getItem(APP . $path);
        }
        
        (new Logger())->logRead(APP . $path);
        
        if (!$items) {
            $template = ROOT . '/template/php/error.php';
            $view = ROOT . '/views/404.php';
            show($template, $view, null);
            return true;
        }

        $template = ROOT . '/template/php/main.php';

        if (@$items['picture']) {
            $view = ROOT . '/views/picture.php';
            $data = ['items' => $items];
            show($template, $view, $data);
            return true;
        }

        if (@$items['folders'] || @$items['images']) {
            $view = ROOT . '/views/folderContent.php';
            $data = ['items' => $items];
            show($template, $view , $data);
            return true;
        }

        //and finally if folder is empty
        $view = ROOT . '/views/emptyFolder.php';
        show($template, $view, null);        
        return true;
    }

    public function actionGetLog() {
        $logger = new Logger();
        $logger->logRead('log');
        $log = $logger->getLog();

        if (!$log) {
            http_response_code(500);
            return true;
        }

        $template = ROOT . '/template/php/main.php';
        $view = ROOT . '/views/log.php';
        $data = ['log' => $log];
        show($template, $view, $data);
        return true;
    }

    public function actionEdit() {
        if (!$this->isXHR() || !$this->pathsIsMatched($_POST['path'])) {
            http_response_code(501);
            return true;
        }

        $path = str_replace('/' . GALLERY, APP, $_POST['path']);
        $name = filter_var($_POST['itemName'], FILTER_SANITIZE_STRING);
        
        $newName = (new Gallery())->renameItem($path, $name);
        
        if ($newName) {
            (new Logger())->logUpdate($path . ' ---> ' . $newName);
            header('Content-Type:text/json;charset=utf-8');
            echo json_encode(['newName' => $newName]);
        } else {
            http_response_code(500);
        }
        
        return true;
    }

    public function actionDelete() {
        if (!$this->isXHR() || !$this->pathsIsMatched($_POST['path'])) {
            http_response_code(501);
            return true;
        }

        $path = str_replace('/' . GALLERY, APP, $_POST['path']);
        $result = (new Gallery())->deleteItem($path);

        if ($result) {
            (new Logger())->logDelete($path);
            http_response_code(200);
        }  else {
            http_response_code(500);
        }
            
        
        return true;
    }

    public function actionCreateFolder() {
        if ( !$this->isXHR()) {
            http_response_code(501);
            return true;
        }

        $name = filter_var($_POST['folder'], FILTER_SANITIZE_STRING);
        $folder = (new Gallery())->createFolder($name);

        if ($folder) {
            http_response_code(200);
            header('Content-Type:text/json;charset=utf-8');
            echo json_encode(['folder' => $folder]);
        } else {
            http_response_code(500);
        }

        return true;
    }
}