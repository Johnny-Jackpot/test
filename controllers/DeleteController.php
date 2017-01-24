<?php

class DeleteController {
    use XHRCheck, PathCheck {
        XHRCheck::isXHR as private;
        PathCheck::pathsIsMatched as private;
    }
    
    public function actionDelete() {
        if (!$this->isXHR() || !$this->pathsIsMatched($_POST['path'])) {
            http_response_code(501);
        }

        $path = str_replace('/' . GALLERY, APP, $_POST['path']);
        $result = Gallery::deleteItem($path);

        if ($result) {
            Logger::logDelete($path);
            http_response_code(200);
        }  else {
            http_response_code(500);
        }
            
        
        return true;
    }
}