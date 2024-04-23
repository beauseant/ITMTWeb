<?php include 'includes/session.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php';?>
</head>

<body>

  <?php include 'includes/topbar.php';?>
  <?php include 'includes/header.php';?>


  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>View model information</h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="listmodels.php">Models</a></li>
            <li>View model</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
      <div class="container">

        <div class="row">
          <div class="col-auto" data-aos="fade-up">
            <div class="testimonial-item">
                <div class="row">
                    <div class="col">
                      <img src="assets/img/testimonials/e.png" class="testimonial-img" alt="">
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col"><b>Model information:</b></div>
                            <div class="col"><h4><?php echo ($_POST['model']);?></h4></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Description:</b></div>
                            <div class="col"><h4><?php echo ($_POST['description']);?></h4></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Creation Date:</b></div>
                            <div class="col"><h4><?php echo ($_POST['creation_date']);?></h4></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>TrDtSet:</b></div>
                            <div class="col"><h4><?php echo ($_POST['trdtset']);?></h4></div>
                        </div>
                    </div>
                </div>
              <div>           
                  <div class="accordion" id="accordionExample">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                      pyLDAvis
                              </button>
                          </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?php 
                                    require_once ( $_SESSION['path_TMmodels'] . '/' . $_POST['model'] . '/TMmodel/pyLDAvis.html');
                                ?>
                            </div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              Topics information for selected model
                          </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                              <?php
                                    $data = shell_exec ('/usr/bin/python3.9 /var/www/html/topicmodeler/src/topicmodeling/manageModels.py --path_TMmodels '  . $_SESSION['path_TMmodels'] . ' --showTopics '. $_POST['model']);                      
                                    $data = json_decode ( $data, true);                        

                                    $listkeys = array_keys(($data['0']));

                                    
                                    $table = '
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>                                    
                                    ';
                                    foreach ($listkeys as $value) {
                                        $table = $table . '<th scope="col">' . $value . '</th>';
                                    }
                                  $table = $table . '
                                            </tr>
                                        </thead>
                                      <tbody>';

                                    foreach ($data as $value) {
                                        $table = $table . '<tr>';
                                        foreach ($listkeys as $key){
                                                $table = $table . '<td>' . $value[$key] . '</td>';
                                            }                                
                                        $table = $table . '</tr>';
                                    }
                            
                                    $table = $table . '
                                            </tbody>
                                        </table>';

                                    echo $table;
                                ?>
                          </div>
                        </div>
                      </div>
                  </div>

            </div>
        </div>
      </div>
    </section><!-- End Testimonials Section -->

  </main><!-- End #main -->

   

<?php include 'includes/footer.php';?>


</body>

</html>