<?php include 'includes/session.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php';?>
  <!--  <link href="assets/css/jqcloud.css" rel="stylesheet"> -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/popper/popper.min.js"></script>
  <!-- <script src="assets/vendor/jqcloud/jqcloud-1.0.4.js"></script> -->
  <script src="assets/vendor/tagify/tagify.js"></script> 
  <link rel="stylesheet" href="assets/vendor/tagify/tagify.css" />

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

      
        <div class="row box" >
          <div class="col">  </div>
          <div class="col"> 
                <div class="row">
                    <div class="col"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteWLModal">Delete wordlist</button></div>
                    <div class="col"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#addWLModal">Add new words</button></div>
                </div>
                <div class="row"></div>
          </div>
          <div class="col">  </div>
      </div>
      <div class="row">

      <div class="col">  </div>
</div>

        <div class="row">
          <div class="col">  </div>
          <div class="col-md-12">
            <div class="icon-box" style="height:10px !important" data-aos="fade-up">
              <div class="icon"><i class="bi bi-briefcase"></i></div>
              <?php echo '<h4 class="title"><a href="">' . $_POST['wlist'] . ' </a></h4>'; ?>
            </div>
            <div class="row box">
                    <?php
                          $error = False;

                          if (isset ($_POST['basicWl'])) {
                              #echo ($_POST['basicWl']);
                              echo '<div class="alert alert-success" role="alert">
                                        Wordlist updated successfully
                                  </div>';
                              #$wl -> updateWordList($_POST['wlist'], explode(',', $_POST['basicWl']));

                          }
                          if (isset ($_POST['wlist'])) { 
                            require_once ('includes/class/class.wordLists.php');
                            $wl = new wordList ();
                            $data = $wl -> getWordListByName($_POST['wlist']);
                            $_SESSION['words'] = array();
                            echo '<ul class="nav navbar navbar-left d-flex d-inline-flex ">';
                            sort ($data['wordlist']);
                            foreach ($data['wordlist'] as $word){
                              #$custom = ['title' => 'My Title', 'class' => 'custom-class' . rand(1,9) ];  
                              #array_push ($_SESSION['words'], ['text' => $word, 'weight' => 5, 'html'=> $custom]);
                                echo '<li class="nav-item d-inline-flex  align-items-center mr-2"><p class="custom-class'. rand(1,9) .' triangle-border left">' . $word . '</p></li>';
                            }
                            echo '</ul>';
                            #echo '<div  id="wordlist" style="  display: table;   margin-right: auto;   margin-left: auto;  width: 850px; height: 550px; border: 0px solid #ccc;"></div>';

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
  /*
      $(function() {
        $("#wordlist").jQCloud( <?php echo json_encode($_SESSION['words'])?>);
      });
  */

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
        <?php
              echo '<p>Are you sure you want to delete the wordlist ' . $_POST['wlist'] . '?</p>'; 
              #echo '<form action="deleteWordList.php" method="post">';
              print_r  ($data);
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="addWLModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new words to <?php echo $_POST['wlist'] ?></h5>
        </button>
      </div>
      <div class="modal-body">
        <form action="viewWordList.php" method="post">
              <label for="basicWl">Add or delete new words</label>
              <!-- <input name='basicWl' value="<?php echo (implode( ',', $data['wordlist'] ) )  ; ?>" autofocus> -->
              <input name='basicWl' class='tagify--outside' value="<?php echo (implode( ',', $data['wordlist'] ) )  ; ?>" placeholder='write words to add below'>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

          <input type="hidden" id="wl" name="wlist" value="<?php echo $_POST['wlist']; ?>">
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>




</html>

<script>
        (function(){
/*        
        // The DOM element you wish to replace with Tagify
var input = document.querySelector('input[name=basicWl]');
input.focus();

// initialize Tagify on the above input node reference
new Tagify(input)
*/
      var input = document.querySelector('input[name=basicWl]')

      var tagify = new Tagify(input, {
          whitelist: [],
          focusable: false,
          dropdown: {
              position: 'input',
              enabled: 0 // always opens dropdown when input gets focus
          }
      })


})()






</script>
