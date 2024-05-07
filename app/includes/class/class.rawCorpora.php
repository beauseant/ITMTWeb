<?php

    class rawCorpora {
        private $rawCorpora = array();
        
        public function __construct() {

            $data = shell_exec ('/usr/bin/python3.9 /var/www/html/topicmodeler/src/manageCorpus/manageCorpus.py --listDownloaded --path_downloaded '. $_SESSION['path_downloaded'] . ' 2>&1');
                        
            $this -> rawCorpora = json_decode ( $data, true);
        }
        
        public function getrawCorpora () {
            return $this->rawCorpora;
        }

        public function getSchemaByName ($name) {
            foreach ($this->rawCorpora as $value) {
                if ($value['name'] == $name) {
                    return $value['schema'];
                }
            }
        }

        public function getRawCorporaByName ( $name ) {
            foreach ($this->rawCorpora as $key => $value) {
                if ($value['name'] == $name) {
                    return (['key' => $key, 'value' => $value]);
                }
            }
            return false;
        }
        
    }

?>
