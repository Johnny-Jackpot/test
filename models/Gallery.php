<?php
/*
    CRUD folders and images
*/
class Gallery {
    /*
        @param string $file
        @return bool
    */
    private static function isAllowedImage($file) {
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
    private static function getLinks($arr, $path) {
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
    private static function getFolder($path) {
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
                    if (self::isAllowedImage($tmp)) $images[] = $item;
                    clearstatcache(true, $tmp);
                }

            }
            $folders = self::getLinks($folders, $path);
            $images = self::getLinks($images, $path);            

            return ['folders' => $folders, 'images' => $images];
    }
    /*
        Return image name or false
        @param string $path
        @return array
    */
    private static function getImage($path) {
        if (self::isAllowedImage($path)) {
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
    public static function getItem($path) {
        
        if (is_dir($path)) {
            return self::getFolder($path);
        } else if (is_file($path)) {
            return self::getImage($path);
        } else {
            return false;
        }
    }

    private static function deleteRecursive($path) {
        if ($items = glob($path . "/*")) {
            foreach($items as $item) {
                is_dir($item) ? self::deleteRecursive($item) : unlink($item);
            }
        }
        return rmdir($path);
    }

    /*
        @param string $path
        @return bool
    */
    public static function deleteItem($path) {
        if (is_dir($path)) {
            return self::deleteRecursive($path);
        }

        return unlink($path);
    }

    public static function renameItem($path, $name) {
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
}