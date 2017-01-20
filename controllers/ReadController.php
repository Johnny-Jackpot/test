<?php

class ReadController {
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
        
        if (!func_num_args()) {
            //load root folder of gallery
            $items = Gallery::getItem(APP);
        } else {
            $folders = func_get_args();
            $path = '/' . implode('/', $folders);
            $items = Gallery::getItem(APP . $path);
        }
        
        if (!$items) {
            require(ROOT . '/views/404/404.php');
            return true;
        }

        if (isset($items['folders']) || isset($items['images'])) {
            if (count($items['folders']) || count($items['images'])) {
                require(ROOT . '/views/app/folderContent.php');
            } else {
                require(ROOT . '/views/app/emptyFolder.php');
            }
        } else if (isset($items['picture'])) {
            require(ROOT . '/views/app/picture.php');
        }

        Logger::logRead(APP . $path);
        
        return true;
    }

    public function actionGetLog() {
        Logger::logRead('log');
        $log = Logger::getLog();

        if (!$log) {
            http_response_code(500);
            return true;
        }

        require(ROOT . '/views/app/log.php');
        return true;
    }
}