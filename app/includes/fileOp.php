<?php
    function filter_filename($name) {
            // remove illegal file system characters https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
            $name = str_replace(array_merge(
                array_map('chr', range(0, 31)),
                array('<', '>', ':', '"', '/', '\\', '|', '?', '*')
            ), '', $name);
            // maximise filename length to 255 bytes http://serverfault.com/a/9548/44086
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $name= mb_strcut(pathinfo($name, PATHINFO_FILENAME), 0, 255 - ($ext ? strlen($ext) + 1 : 0), mb_detect_encoding($name)) . ($ext ? '.' . $ext : '');
            $name = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $name);
            $name = mb_ereg_replace("([\.]{2,})", '', $name);
            $name = str_replace(' ','',$name);
            return  ($name);
    }

    function saveArrayAsJsonFile($data, $filename){

        $json = json_encode($data, JSON_UNESCAPED_SLASHES);
        $len = file_put_contents($filename, $json);

        $error = ($len==0) ? True : False;

        return $error;

    }

    function openJsonFile ($filename) {
        $data = file_get_contents($filename);
        return json_decode($data, true);
    }


    function deleteFile($filename){
            if (!unlink($filename)) { 
                return -1;
            }else { 
                return 0;    
            } 

    }

    function join_paths(...$parts) {
        if (sizeof($parts) === 0) return '';
        $prefix = ($parts[0] === DIRECTORY_SEPARATOR) ? DIRECTORY_SEPARATOR : '';
        $processed = array_filter(array_map(function ($part) {
            return rtrim($part, DIRECTORY_SEPARATOR);
        }, $parts), function ($part) {
            return !empty($part);
        });
        return $prefix . implode(DIRECTORY_SEPARATOR, $processed);
    }

    function createDirectory ($path){
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    function deleteDir(string $dirPath): void {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
    function dirToArray($dir) {

   

        $result = array();
     
     
     
        $cdir = scandir($dir);
     
        foreach ($cdir as $key => $value)
     
        {
     
           if (!in_array($value,array(".","..")))
     
           {
     
              if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
     
              {
     
                 $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
     
              }
     
              else
     
              {
     
                 $result[] = $value;
     
              } 
     
           }
     
        }
     
        
     
        return $result;
     
     }


?>




