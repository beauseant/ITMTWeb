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
          <div class="col-lg-4 col-md-6">
                <?php


                  require_once ('includes/class/class.rawCorpora.php');
                  $rc = new rawCorpora ();
                  
                  $table = '<form action="createLogicalCorporaResults.php" method="post">
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
                                                    <select id="fields" name="fields[]">
                                                          <option value="id|'.  $modelName. '|' . $value.  '">Id</option>
                                                          <option value="text|'.  $modelName. '|' . $value.  '">Text</option>
                                                          <option value="lemmas|'.  $modelName. '|' . $value.  '">Lemmas</option>
                                                          <option value="embeddings|'.  $modelName. '|' . $value.  '">Embeddings</option>
                                                    </select>
                                          </td>
                                          <td><input type="checkbox" name="models[]" value="' . $modelName. '|' . $value. '"> </td>
                                    </tr>';
                        }
                  }                  
                  
                  $table = $table .'<tr><td colspan="3">
                                        <input type="submit" name="anmelden" id="btncheck" class="btn btn-primary" id="btncheck" value="Create logical corpus"   />

                                     </td></tr>
                                    ';
                  $table = $table . '</tbody></table>

                                    </form>';
                  echo $table;
                ?>

          </div>
        </div>
      </div>
      <div>
    </section><!-- End Services Section -->














  </main><!-- End #main -->
  <?php include 'includes/footer.php';?>


</body>

</html>