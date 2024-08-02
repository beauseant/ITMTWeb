<?php
    class trainFiles {
        private $data;
	private $params;
        
        public function __construct( $params ) {
		$this -> data = array();
		$this -> params = $params;
		switch ($params['AlgType']) {
			case "mallet":
				$this -> generateMallet ();
				break;
			case "prodlda":
				$this -> generateProdla ();
				break;
			case "ctm":
				$this -> generateCtm ();
				break;
			case "bertopic":
				$this -> generateBertopic ();
				break;
		}
	}

	private function generateCommon () {
                $this -> data ['visibility'] = $this -> params['visibility'];
                $this -> data ['TrDtSet'] = $this -> params['key'];
                $this -> data ['Preproc']['stopwords']= $this -> params['wordlist'];
                $this -> data ['Preproc']['equivalences'] = $this -> params['eqlist'];
		$this -> data ['description'] = $this -> params['description'];
		$this -> data ['name'] = $this -> params ['modelName'];
	
	}

	private function generateMallet (){
  		$string = file_get_contents('data/example_mallet.json');
  		$this -> data  = json_decode($string, true);
		$this -> data ['TMparam']['mallet_path'] =  $_SESSION['mallet_path'];
		$this -> generateCommon ();
    	}
	
        private function generateProdla (){
                $string = file_get_contents('data/example_prod.json');
                $this -> data  = json_decode($string, true);
                $this -> generateCommon ();
        }


        private function generateCtm (){
                $string = file_get_contents('data/example_ctm.json');
                $this -> data  = json_decode($string, true);
                $this -> generateCommon ();
        }


        private function generateBertopic (){
                $string = file_get_contents('data/example_bertopic.json');
                $this -> data  = json_decode($string, true);
                $this -> generateCommon ();
        }

	public function getData ( $asString = False ) {
		if ($asString){
			return json_encode($this -> data ,JSON_PRETTY_PRINT );
		}else {
			return $this -> data;
		}
	}

	public function saveFile ( $ruta ){
		$string = json_encode($this -> data);
		$string = str_replace ('\/','/',$string);
		$fhandle = fopen($ruta,"w");
		fwrite ($fhandle, $string);
		fclose ($fhandle);
	}
    }

?>
