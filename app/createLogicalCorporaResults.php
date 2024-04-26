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

                foreach ( $_POST['models'] as $model ){
                    $data = explode($separator, $model);

                    if (!array_key_exists($data[0], $modelsSelected)){
                        $modelsSelected[$data[0]] = array();
                    }

                    $fieldType = searchFieldType ($fields[$data[0]], $data[1]);
                    array_push ($modelsSelected[$data[0]], ['field' => $data[1], 'type' => $fieldType]);

                }
                
            ?>  
            <?php
            // Code above...

            // Create HTML table from $modelsSelected
            echo '<table>';
            foreach ($modelsSelected as $model => $fields) {
              echo '<tr><th colspan="2">' . $model . '</th></tr>';
              foreach ($fields as $field) {
                echo '<tr><td>' . $field['field'] . '</td><td>' . $field['type'] . '</td></tr>';
              }
            }
            echo '</table>';

            // Code below...
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