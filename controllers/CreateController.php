<?php

class CreateController {

    use XHRCheck, PathCheck {
        XHRCheck::isXHR as private;
    }

    public function actionCreateFolder() {
        if ( !$this->isXHR()) {
            http_response_code(501);
        }

        $name = filter_var($_POST['folder'], FILTER_SANITIZE_STRING);
        $folder = Gallery::createFolder($name);

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