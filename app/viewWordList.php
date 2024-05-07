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
          <h2>Wordlist</h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="listWordLists.php">Wordlist</a></li>
            <li>view wordlist</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

      
        <div class="row" style="1px solid #ebe6e4 !important; background: #faf9f8 !important ; padding-bottom:60px; padding-top:60px;">
          <div class="col">  </div>
          <div class="col"> 
                <div class="row">
                    <div class="col"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteWLModal">Delete wordlist</button></div>
                    <div class="col"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#addWLModal">Add new words</button></div>
                </div>
          </div>
          <div class="col">  </div>
      </div>
      <div class="row">

      <div class="col">  </div>
</div>

        <div class="row">
          <div class="col">  </div>
          <div class="col-md-12">
            <div class="icon-box" style="height:800px; !important" data-aos="fade-up">
              <div class="icon"><i class="bi bi-briefcase"></i></div>                    
                    <?php
                          $error = False;
                          if ($_POST['wlist']) {                     
                            echo '<h4 class="title"><a href="">' . $_POST['wlist'] . ' </a></h4>';
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
                            
                            echo '<div  id="wordlist" style="  display: table;   margin-right: auto;   margin-left: auto;  width: 850px; height: 550px; border: 0px solid #ccc;"></div>';

                          }else{
                            $error = True;
                          }

                          if ($error){
                            echo '<div class="alert alert-danger" role="alert">
                                        Error, no wordlist selected<br><a href="listWordLists.php">Go back and try again</a>
                                  </div>';
                          }


                  ?>
            </div> <!--fadeup-->
          </div><!--col-->
          <div class="col">  </div>
        </div><!--row-->
      </div><!--container-->
    </section><!-- End Services Section -->

    <?php include 'includes/footer.php';?>


</body>
<script type="text/javascript">
      $(function() {
        $("#wordlist").jQCloud( <?php echo json_encode($_SESSION['words'])?>);
      });
</script>


<!-- Modal -->
<div class="modal fade" id="deleteWLModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="addWLModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>




</html>
