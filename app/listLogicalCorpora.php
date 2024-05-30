<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php';?>
  <link href="assets/css/spinner.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/vendor/dataTables/dataTables.dataTables.css" />
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/dataTables/dataTables.js"></script>



  <script>

          $(document).ready(function(){
              $.ajax({
                  url: 'includes/loadLogicalCorpora.php',
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
            <li>Logical corpora</li>
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
            <div id="loadercont">
                <div id="loader"></div>
            </div>
            <div style="display:none;" id="myDiv" class="animate-bottom">
                <h2>Tada!</h2>
                <p>Some text in my newly loaded page..</p>
            </div>
          </div>
          <div class="col-sm"></div>
        </div>
      </div>
      <div>
    </section><!-- End Services Section -->


  </main><!-- End #main -->
  <?php include 'includes/footer.php';?>


</body>

</html>