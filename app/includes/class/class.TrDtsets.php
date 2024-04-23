<?php

    class trdList {
        private $trDtsets = array();
        
        public function __construct() {

            $data = shell_exec ('/usr/bin/python3.9 /var/www/html/topicmodeler/src/manageCorpus/manageCorpus.py --listTrDtsets --path_datasets ' .  $_SESSION['path_datasets']   . ' 2>&1');

            $this -> trDtsets = json_decode ( $data, true);
        }
        
        public function getTrDtsets() {
            return $this->trDtsets;
        }
        
        public function getTrDtsetsByName ( $name ) {
            foreach ($this->trDtsets as $key => $value) {
                if ($value['name'] == $name) {
                    return (['key' => $key, 'value' => $value]);
                }
            }
            return false;
        }
    }

?>
