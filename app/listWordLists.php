<?php include 'includes/session.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php';?>
  <link href="assets/css/spinner.css" rel="stylesheet">
  <script src="assets/vendor/jquery/jquery.min.js"></script>

  <script>

          $(document).ready(function(){
              $.ajax({
                  url: 'includes/loadWordLists.php',
                  type: 'GET',
                  dataType: 'html',
                  success: function(data) {
                      $('#myDiv').html(data);
              //Moved the hide event so it waits to run until the prior event completes
              //It hide the spinner immediately, without waiting, until I moved it here
                      $('#loader').hide();
                      $('#loadercont').hide();
                      $('#myDiv').show();
                  },
                  error: function() {
                      alert("Something went wrong!");
                  }
              });
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
            <li>Wordlists</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">
        <?php
                require_once ('includes/fileOp.php');

                /*Si venimos de borrar lista entocnes debemos borrarla*/ 
                if (isset ($_POST['btnBorrar'])){
                    $error = deleteFile ($_POST['path']); 
                    if ($error == 0) {
                      echo '<div class="alert alert-success" role="alert">
                              Wordlist' . $_POST['wlist']. 'deleted successfully
                            </div>';
                    }else {
                      echo '<div class="alert alert-danger" role="alert">
                              Error deleting wordlist ' . $_POST['wlist'] . ' 
                            </div>';
                    }
                }

                /* si venimos desde crear wordlist createWordlist.php, entonces en el post tendremos los datos de la lista creada*/
                if (isset ($_POST['wlname'])){
                  /*limpiamos el nombre*/
                  $name = filter_filename($_POST['wlname']);
                  $data = array();
                  $data['name'] = $name;
                  $data['wordlist'] = json_decode ($_POST['words']);
                  $data['description'] = $_POST['wldescription'];
                  $data['valid_for'] = $_POST['type'];
                  if (isset ($_POST['visibility'])) {
                    $data['visibility'] = 'private';
                  }else{
                    $data['visibility'] = 'public';
                  }
                  $data['creation_date'] = gmdate('Y-m-d h:i:s \G\M\T');

                  $file = $_SESSION['path_wordlists'] . '/' . $name . '.json';
                  
                  $error = saveArrayAsJsonFile( $data, $file );

                  if (!$error) {
                    echo '<div class="alert alert-success" role="alert">
                            Wordlist "' .  $data['description']  . '" created successfully
                          </div>';
                  }else {
                    echo '<div class="alert alert-danger" role="alert">
                            Error creating wordlist ' . $file . '
                          </div>';
                  }
                }
        ?>
        <div class="row">

          <div class="col-sm">
            <div id="loadercont">
                <div id="loader"></div>
            </div>
            <div style="display:none;" id="myDiv" class="animate-bottom">
                <h2>Tada!</h2>
                <p>Some text in my newly loaded page..</p>
            </div>
          </div>
            
        </div>
      </div>
      <div>
    </section><!-- End Services Section -->


  </main><!-- End #main -->
  <?php include 'includes/footer.php';?>


</body>

</html>