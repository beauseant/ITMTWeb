<?php include 'includes/session.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php';?>

  <script src="assets/vendor/jquery/jquery.min.js"></script>

  <script>



</script>

<style>

        div.scroll {
            margin: 4px, 4px;
            padding: 4px;
            background-color: #747774;
            color:#efefef;
            width: 500px;
            height: 510px;
            overflow-x: hidden;
            overflow-y: auto;
            text-align: justify;
        }
    </style>

</head>

<body>

  <?php include 'includes/topbar.php';?>
  <?php include 'includes/header.php';?>

  <main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>About</h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li>About</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->




    <!-- ======= About Us Section ======= -->
    <section id="about-us" class="about-us">
      <div class="container">
          <div class="row">
                <div class="col-sm">
                    <?php
                        if (!isset ($_POST['modelName'])){
                            echo '<div class="alert alert-danger" role="alert">
                                      Model name not specified
                                  </div>';
                            exit();
                        }
                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/topicmodeler/.env")) {
                              $apikey = explode("=", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/topicmodeler/.env"))[1];
                              echo '<div class="alert alert-success" role="alert">
                                        OPEN API KEY file found!!!!                                        
                                  </div>';
                        }else {
                          echo '<div class="alert alert-danger" role="alert">
                                    OPEN API KEY file not found!!!!, Please create a file with de the key in the following path:' . $_SERVER['DOCUMENT_ROOT'] . '/topicmodeler/.env
                              </div>';
                              exit();
                        
                        }                  
                    ?>
                    Entrenando el modelo, por favor espere...
		                <br><br>
		                El fichero de configuración generado es el siguiente:
                    <br><br>
                    <?php
                            require_once ('includes/class/class.TrDtsets.php');
                            $tl = new trdList();
                            $data = $tl ->getTrDtsetsByName ($_POST['modelName']);
                            $_POST['key'] = $data['key'];

                            require_once ('includes/class/class.TrainingFiles.php');
                            $tf = new trainFiles ($_POST);
                            print ($tf -> getData( $asString = True));
                            $tf -> saveFile ($_SESSION['temporaltrainfile']);

                            $cmd = '/usr/bin/python3.9 /var/www/html/topicmodeler/src/topicmodeling/topicmodeling.py --open_ai_key '. $apikey .' --do_logger True --train --config ' .$_SESSION['temporaltrainfile']. ' 2>&1';
                            echo "<br><br> El comando será:<br><br>";

                            #$api = getenv('OPENAI_API_KEY', true) ?: getenv('OPENAI_API_KEY');
                            #print_r( $api );                            
                            echo '/usr/bin/python3.9 /var/www/html/topicmodeler/src/topicmodeling/topicmodeling.py --open_ai_key '. 'XXXXXXXX' .' --do_logger True --train --config ' .$_SESSION['temporaltrainfile']. ' 2>&1';
		                  ?>
                </div>
                <div class="col-sm">
                      <div class="scroll">
                        <?php

                                $descriptorspec = array(
                                0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
                                1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
                                2 => array("pipe", "w")    // stderr is a pipe that the child will write to
                                );
                                flush();
                                $process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());
                                echo "<pre>";
                                if (is_resource($process)) {
                                    while ($s = fgets($pipes[1])) {
                                        print $s;
                                        flush();
                                    }
                                }
                                
                                echo "</pre>";
                        ?>
                      </div><!-- End #scroll -->
                  </div>
                <div class="col-sm">
                      <div class="alert alert-success" role="alert">
                            Model training completed, check the output to see the result
                      </div>
                </div>                
            </div>
        </div>            
    </section>
  </main><!-- End #main -->
  <?php include 'includes/footer.php';?>


</body>

</html>
