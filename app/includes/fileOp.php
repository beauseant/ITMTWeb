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
            return $name;
    }

    function saveArrayAsJsonFile($data, $filename){

        $json = json_encode($data);
        $len = file_put_contents($filename, $json);

        $error = ($len==0) ? True : False;

        return $error;

    }

?>
