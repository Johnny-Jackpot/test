<?php 

class EditController {
    use XHRCheck, PathCheck {
        XHRCheck::isXHR as private;
        PathCheck::pathsIsMatched as private;
    }

    public function actionEdit() {
        if (!$this->isXHR() || !$this->pathsIsMatched($_POST['path'])) {
            http_response_code(501);
        }

        $path = str_replace('/' . GALLERY, APP, $_POST['path']);
        $name = filter_var($_POST['itemName'], FILTER_SANITIZE_STRING);
        
        $result = Gallery::renameItem($path, $name);
        
        if ($result) {
            header('Content-Type:text/json;charset=utf-8');
            echo json_encode(['newName' => $result]);
        } else {
            http_response_code(500);
        }
        
        return true;
    }
}