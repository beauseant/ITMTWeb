<?php include 'includes/session.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php';?>
  <link href="assets/css/jqcloud.css" rel="stylesheet">
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/popper/popper.min.js"></script>
  <script src="assets/vendor/jqcloud/jqcloud-1.0.4.js"></script>


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
          <div class="col-md-auto">
                    <?php

                      $error = False;

                      if ($_POST['wlist']) {                        
                        echo $_POST['wlist'];
                        require_once ('includes/class/class.wordLists.php');
                        $wl = new wordList ();
                        $data = $wl -> getWordListByName($_POST['wlist']);


                        $_SESSION['words'] = array();
                        foreach ($data['wordlist'] as $word){
                          $custom = ['title' => 'My Title', 'class' => 'custom-class' . rand(1,9) ];  
                          array_push (
                                $_SESSION['words'], ['text' => $word, 'weight' => 5, 'html'=> $custom]
                            );
                        }
                        echo '<div   id="my_favorite_latin_words2" class="col-md-auto">';
                        
                        #echo '<div id="my_favorite_latin_words2" style="width: 850px; height: 850px; border: 0px solid #ccc;"></div>';

                      }else{
                        $error = True;
                      }

                      if ($error){
                        echo '<div class="alert alert-danger" role="alert">
                                    Error, no wordlist selected<br><a href="listWordLists.php">Go back and try again</a>
                              </div>';
                      }

                      
                    ?>                          
                    </div>
            </div><!-- row -->
      <div><!-- container -->
    </section><!-- End Services Section -->

  </main><!-- End #main -->
  <?php include 'includes/footer.php';?>


</body>
<script type="text/javascript">
      $(function() {
        $("#wordlist").jQCloud( <?php echo json_encode($_SESSION['words'])?>);
      });
    </script>


</html>
