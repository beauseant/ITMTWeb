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
              <?php echo '<h4 class="title">' . $_POST['wlist'] . '</h4>'; ?>
            </div>
            <div class="row box">
                    <?php

                          require_once ('includes/class/class.wordLists.php');
                          $wl = new wordList ();


                          if (isset ($_POST['basicWl'])) {
                              require_once ('includes/fileOp.php');
                              $path = $wl -> getWordListPath  ($_POST['wlist']);
                              $filedata = openJsonFile ($path);
                              
                              $data = array();
                              $data['name'] = $filedata['name'];                              

                              $data['wordlist'] = array();
                              $arraylist = json_decode ($_POST['basicWl'],true);
                              foreach ($arraylist as $word){
                                array_push ($data['wordlist'], $word['value']);
                              } 

                              sort ($data['wordlist']);
                              $data['description'] = $filedata['description'];
                              $data['valid_for'] = $filedata['valid_for'];
                              $data['visibility'] = $filedata['visibility'];
                              $data['creation_date'] = gmdate('Y-m-d h:i:s \G\M\T');

                              #print_r ($data);

                              $error = saveArrayAsJsonFile( $data, $path );    

                              if (!$error) {
                                      echo '<div class="alert alert-success" role="alert">
                                              Wordlist "' .  $data['description']  . '" update successfully
                                            </div>';
                              }else {
                                echo $path;
                                echo '<div class="alert alert-danger" role="alert">
                                        Error updating wordlist, writing file ' . $path . '
                                      </div>';
                              }

                          }

                          $error = False; 
                          if (isset ($_POST['wlist'])) { 
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
    </main>
    <?php include 'includes/footer.php';?>



            <script>
                function checkInput() {
                  var myTextBox = document.getElementById('listNameInput');
                  var hiddenTextBox = document.getElementById('wordlistname');
                  var nombre = hiddenTextBox.value;       
                  var value = myTextBox.value;
                  document.getElementById("btnBorrar").disabled = true;
                  if (value.localeCompare(nombre) ==0){
                    myTextBox.style.backgroundColor = 'green';
                    document.getElementById("btnBorrar").disabled = false;
                  } else {
                    myTextBox.style.backgroundColor = 'red';  
                  }
                }


            </script>

            <!-- Modal -->
            <div class="modal fade" id="deleteWLModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                      <span aria-hidden="true">&times;</span>
                  </div>
                  <form id="deleteform" action="listWordLists.php" method="post">
                  <div class="modal-body">
                    <?php
                          $path = $wl -> getWordListPath  ($_POST['wlist']);
                          echo '<p>Are you sure you want to delete the wordlist ' . $_POST['wlist'] . '?</p>'; 
                          echo '                              
                                  <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label">Type the name of the list to complete the deletion.</label>
                                  <input onKeyUp="checkInput()"   class="form-control" id="listNameInput">
                                </div>                                        
                          ';
                    ?>
                  </div>
                  <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button name="btnBorrar" type="submit" disabled id="btnBorrar"  class="btn btn-danger">Delete</button>
                        <input type="hidden" name="wlist" id="wordlistname" value="<?php echo $_POST['wlist'];?>"/>                      
                        <input type="hidden" name="path" id="wordlistpath" value="<?php echo $path  ;?>"/>                      
                    </form>


                  </div>
                </div>
              </div>
            </div>



            <div class="modal fade" id="addWLModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new words to <?php echo $_POST['wlist'] ?></h5>  
                  </div>
                  <form id="idAddWords" action="viewWordList.php" method="post">
                    <div class="modal-body">
                          <label for="basicWl">Add or delete new words</label>
                          <!-- <input name='basicWl' value="<?php echo (implode( ',', $data['wordlist'] ) )  ; ?>" autofocus> -->
                          <input name='basicWl' class='tagify--outside' value="<?php echo (implode( ',', $data['wordlist'] ) )  ; ?>" placeholder='write words to add below'>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type="hidden" id="wl" name="wlist" value="<?php echo $_POST['wlist']; ?>">
                      <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>



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
</body>   


</html>
