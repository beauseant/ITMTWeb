<?php include 'includes/session.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php';?>
  <link href="assets/css/spinner.css" rel="stylesheet">
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/popper/popper.min.js"></script>





</head>

<body>

  <?php include 'includes/topbar.php';?>
  <?php include 'includes/header.php';?>

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Services</h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li>Raw Corpora</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">
        <div class="row">
          <div class="col-sm"></div>
          <div class="col-sm">
              <?php
		
                function searchFieldType ($model, $field){
                    foreach ($model as $key => $value){
                        if ($value['field'] == $field)
                            return $value['type'];
                        }        
                    return -1;
                }

                $separator = "|";

                $fields = array();
                foreach ( $_POST['fields'] as $field ){
                    $data = explode($separator, $field);

                    if (!array_key_exists($data[1], $fields))
                        $fields[$data[1]] = array();

                    array_push ($fields[$data[1]], ['field' => $data[2], 'type' => $data[0]]);

                }

                #print_r (searchInFields ($fields, 'id'));
                #print searchFieldType ($fields['CORDIS.parquet'], 'title');

                $modelsSelected = array();
                
                #Comprueba que haya un solo id para cada corpus:
                $numIdsErrors = False;
                $numIds = array();

                $numLemmas = array();
                $numLemmasErrors = False;


                foreach ( $_POST['models'] as $model ){
                    $data = explode($separator, $model);

                    if (!array_key_exists($data[0], $modelsSelected)){
                        $modelsSelected[$data[0]] = array();
                    }

                    $fieldType = searchFieldType ($fields[$data[0]], $data[1]);
                    array_push ($modelsSelected[$data[0]], ['field' => $data[1], 'type' => $fieldType]);

                }


                /* #######################################################                
                  Sólo debe existir un ID para cada modelo, debe haber una forma más sencilla de hacerlo, pero....
                  Lo mismo con los lemas, al menos un lemma para cada corpus
                  /* #######################################################
                
                */
                foreach ($modelsSelected as $key => $model ) {
                    $numIds[$key] = 0;
                    $numLemmas[$key] = 0;
                    foreach ($model as $field) {
                      if ($field['type'] == 'id'){
                          $numIds[$key] += 1;
                      }
                      if ($field['type'] == 'lemmas'){
                          $numLemmas[$key] += 1;
                      }
                    }
                }

                foreach ($numIds as $model => $num){
                    if ($num != 1){
                        $numIdsErrors = True;
                    }
                }

                foreach ($numLemmas as $model => $num){
                  if ($num == 0){
                      $numLemmasErrors = True;
                  }
              }

                /* #######################################################
                #######################################################
                */
                
                $error = False;
                if ($numIdsErrors){
                    $error = True;
                    echo '    <div class="alert alert-danger" role="alert">
                                  You must select exactly one id field for each corpus.
                                  <a href="listRawCorpora.php" class="alert-link">Go back</a> and try again.
                              </div>
                    ';
                }
                if ($numLemmasErrors){
                  $error = True;
                  echo '    <div class="alert alert-danger" role="alert">
                                You must select at least one lemmas field for each corpus selected.
                                <a href="listRawCorpora.php" class="alert-link">Go back</a> and try again.
                            </div>';
                }

                $error2 = False;
                if (!$error){
                    require_once ('includes/class/class.rawCorpora.php');
                    $rc = new rawCorpora ();

                    $Dtsets = array();
                    $Dtsets['id'] =  uniqid();
                    $Dtsets['description'] = $_POST['description'];
                    $Dtsets['name'] = $_POST['name'];
                    $Dtsets['creator'] = 'ITMTWeb';
                    $Dtsets['valid_for'] = 'TM';
                    $Dtsets['creation_date'] = gmdate('Y-m-d h:i:s \G\M\T');
                    $Dtsets['visibility'] = $_POST['private'];

                    foreach ($modelsSelected as $model => $fields) {
                        $item = array();
                        $modelData = $rc -> getRawCorporaByName ($model);

                        $item['parquet'] = $modelData['key'];
                        $item['source'] =  $modelData['value']['source'];
                        $item['filter'] =  '';

                        $lemmas = array();

                        foreach ($fields as $field){
                          if ($field['type'] == 'lemmas'){                          
                              array_push ($lemmas, $field['field']);                                  
                          }
                          if ($field['type'] == 'id'){
                              $item['idfld'] = $field['type'];
                          }
                          if ($field['type'] == 'embeddings'){
                            $item['embeddingsfld'] = $field['type'];
                        }

                        }
                        $item['lemmasflds'] = $lemmas;
                        $Dtsets['Dtsets']= $item;
                    }
                    $data = json_encode($Dtsets, JSON_UNESCAPED_SLASHES);
                    $file = $_SESSION['path_datasets'] . '/' . $Dtsets['name'] . '.json';

                    if (file_put_contents($file, $data) == false) {                    
                      echo '<div class="alert alert-danger" role="alert">
                                Error writing data to file, ' . $file . '.                                    
                          </div>';
                      $error2 = True;
                    }
                  }
                  if (!$error2){        

                        echo '    <div class="alert alert-info" role="alert">
                                  Corpus generated.
                            </div>';                     
                    
                        echo '    <div class="alert alert-info" role="alert">
                                  You have selected the following fields:
                        </div>';    

                        echo '<table class="table">';
                        foreach ($modelsSelected as $model => $fields) {
                          echo '<tr><th colspan="2">' . $model . '</th></tr>';
                          foreach ($fields as $field) {
                            echo '<tr><td>' . $field['field'] . '</td><td>' . $field['type'] . '</td></tr>';
                          }
                        }
                        echo '<tr>
                                      <td><a  class="btn btn-link" role="button" href="listLogicalCorpora.php">View the corpus</a></td>
                                      <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal">View generated file</button></td>
                              </tr>';                        
                        echo '</table>';


                  } /* no error*/


            // Code below...
            ?>
            </div><!--Col -->
            <div class="col-sm"></div>

</div><!--Row -->
</div><!--Container -->

</section><!-- End Services Section -->





<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New corpus:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                  <?php
                    echo '<pre>' . json_encode($Dtsets, JSON_PRETTY_PRINT)  . '</pre><br><hr>File: ' . $file . '<br>'; 

                  ?>
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>









</main><!-- End #main -->
<?php include 'includes/footer.php';?>


</body>

</html>            
