<?php
/*
    CRUD folders and images
*/
class Gallery {
    /*
        @param string $file
        @return bool
    */
    private function isAllowedImage($file) {
        switch (exif_imagetype($file)) {
            case IMAGETYPE_GIF:
            case IMAGETYPE_JPEG:
            case IMAGETYPE_PNG:
                return true;
                break;
            default:
                return false;
                break;
        }
    }
    /*
        Adding relative links to folders and images for appropriate routing
        @param array $arr - folders/images names
        @param string $path
        @return array
    */
    private function getLinks($arr, $path) {
        $path = str_replace(APP, '', $path);        

        $links = [];
        for($i = 0, $n = count($arr); $i < $n; $i++) {
            $links[$i] = [];
            $links[$i]['link'] = '/' . GALLERY . $path . '/' .  $arr[$i];
            $links[$i]['name'] = $arr[$i];
        } 
        return $links;
    }
    /*
        Return names of folders and images
        @param string $path
        @return array
    */
    private function getFolder($path) {
        clearstatcache(true, $path);
            $items = scandir($path);

            $folders = [];
            $images = [];
            foreach ($items as $item) {
                
                if ($item === '.' || $item === '..') continue;

                if (is_dir($tmp = $path . "/${item}")) {
                    clearstatcache(true, $tmp);
                    $folders[] = $item;
                } else if (is_file($tmp = $path . "/${item}")) {
                    if ($this->isAllowedImage($tmp)) $images[] = $item;
                    clearstatcache(true, $tmp);
                }

            }
            $folders = $this->getLinks($folders, $path);
            $images = $this->getLinks($images, $path);            

            return ['folders' => $folders, 'images' => $images];
    }
    /*
        Return image name or false
        @param string $path
        @return array
    */
    private function getImage($path) {
        if ($this->isAllowedImage($path)) {
            $picture = str_replace(ROOT, '', $path);
            return ['picture' => $picture];
        }

        return false;
    }

    /*
        Return content of folder or relative link to image or false
        @param string $path
        @return array|bool
    */
    public function getItem($path) {
        $path = urldecode($path);
        if (is_dir($path)) {
            return $this->getFolder($path);
        } else if (is_file($path)) {
            return $this->getImage($path);
        } else {
            return false;
        }
    }

    private function deleteRecursive($path) {
        if ($items = glob($path . "/*")) {
            foreach($items as $item) {
                is_dir($item) ? $this->deleteRecursive($item) : unlink($item);
            }
        }
        return rmdir($path);
    }

    /*
        @param string $path
        @return bool
    */
    public function deleteItem($path) {
        if (is_dir($path)) {
            return $this->deleteRecursive($path);
        }

        return unlink($path);
    }

    /*
        @param string $path
        @param string $name
        @return bool
    */
    public function renameItem($path, $name) {
        if (!file_exists($path)) return false;

        $pathArr = explode('/', $path);
        $oldName = array_pop($pathArr);
        $newNameArr = array_push($pathArr, $name);

        $newName = implode('/', $pathArr);

        if (is_dir($path)) {
            return rename($path, $newName) ? $name : false;
        } else if (is_file($path)) {
            $ext = explode('.', $path)[1];
            $newName = $newName . '.' . $ext;
            $imageName = explode('/', $newName);
            $imageName = array_pop($imageName);
            return rename($path, $newName) ? $imageName : false;
        }
    }

    /*
        @param string $name
        @return bool
    */
    public function createFolder($name) {
        $httpOrigin = $_SERVER['HTTP_ORIGIN'];
        $path = urldecode( $_SERVER['HTTP_REFERER']);
        $path = preg_replace("~$httpOrigin~", '', $path);
        $realPath = str_replace('/' . GALLERY, APP, $path);

        if (!file_exists($realPath)) return false;

        $realPath .= '/' . $name;
        
        return (mkdir($realPath)) ? $path . '/' . $name : false;
    }
}