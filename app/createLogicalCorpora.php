<?php include 'includes/session.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php';?>
  <link href="assets/css/spinner.css" rel="stylesheet">
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/popper/popper.min.js"></script>
  <script>  
            $(document).on('change','.check',function() {
                    $('#btncheck').prop("disabled", !this.checked);
            });
  </script>


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
        <?php
                    if (!isset ($_POST['model'])) {
                      echo '
                            <div class="alert alert-danger" role="alert">
                                  No model selected
                            </div>
                      ';
                          exit;
                    }        
        ?>
        <div class="row">
                <div class="col-sm"></div>
              <div class="col-md-auto">
                    <?php

                      $private = in_array ('private', $_POST) ? 'Public' : 'Private';

                      require_once ('includes/class/class.rawCorpora.php');
                      $rc = new rawCorpora ();
                      
                      $table = '<form action="createLogicalCorporaResults.php" method="post">
				  <input type="hidden" id="privatecheck" name="private" value="'. $private . '" />
                                  <input type="hidden"  name="name" value="'. $_POST['name'] . '" />
                                  <input type="hidden"  name="description" value="'. $_POST['description'] . '" />
                                  <table class="table table-striped">
                                    <thead class="thead-dark">
                                          <tr>
                                            <th scope="col">Corpus</th>
                                            <th scope="col">Field</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Select</th>
                                        </tr>
                                    </thead>
                                    <tbody>                  
                      ';
                      foreach ($_POST['model'] as $modelName ) {
                            $schema = $rc -> getSchemaByName ($modelName);
                            $table = $table . 
                                  '
                                  <tr>
                                        <td rowspan='. count ($schema) +1 . '>' . $modelName . '</td>
                                  </tr>';
                            foreach ($schema as $value) {
                                  $table = $table . 
                                        '<tr>
                                              <td>' . $value . '</td>
                                              <td> 
                                                        <select class="form-control form-control-sm" id="fields" name="fields[]">
                                                              <option value="id|'.  $modelName. '|' . $value.  '">Use as Id type</option>
                                                              <option value="text|'.  $modelName. '|' . $value.  '">Use as Text type</option>
                                                              <option value="lemmas|'.  $modelName. '|' . $value.  '">Use as Lemmas type</option>
                                                              <option value="embeddings|'.  $modelName. '|' . $value.  '">Use as Embeddings type</option>
                                                        </select>
                                              </td>
                                              <td><input  type="checkbox" class="check" name="models[]" value="' . $modelName. '|' . $value. '"> </td>
                                        </tr>';
                            }
                      }                  
                      
                      $table = $table .'<tr><td colspan="4">
                      <button type="submit"  id="btncheck"  class="btn btn-primary" disabled >Save</button/>
                                  </td></tr>


                                        </td></tr>
                                        ';
                      $table = $table . '</tbody></table>

                                        </form>';
                      echo $table;
                    ?>
              </div>
              <div class="col-sm"></div>
            </div><!-- row -->
      <div><!-- container -->
    </section><!-- End Services Section -->





  </main><!-- End #main -->
  <?php include 'includes/footer.php';?>


</body>

</html>
