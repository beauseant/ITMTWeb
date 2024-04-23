<?php

    class wordList {
        private $wordLists = array();
        private $equivalences = array();
        private $rawData = array();
        
        public function __construct() {

            $data = shell_exec ('/usr/bin/python3.9 /var/www/html/topicmodeler/src/manageLists/manageLists.py --listWordLists --path_wordlists ' . $_SESSION['path_wordlists'] . ' 2>&1');
                        
            $data = json_decode ( $data, true);
        

            foreach ($data as $key => $value )  {
                #$data = ['ruta'=>$key];
                #$data = ['name'=>$value['name']];

                if ($value['valid_for'] == 'equivalences') {
                    array_push ($this->equivalences,['path'=>$key, 'name' => $value['name']]);
                }else {
                    array_push ($this->wordLists,['path'=>$key, 'name' => $value['name']]);
                }
            }
            $this->rawData = $data;
        }
        
        public function getWordList() {
            return $this->wordLists;
        }
        public function getEquivalnces() {
            return $this->equivalences;
        }
        public function getRawData() {
            return $this->rawData;
        }        
        
    }

?>