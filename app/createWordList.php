<?php include 'includes/session.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php';?>
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

        <div class="row">
          <div class="col">
          </div>
          <div class="col-lg-8 ">
            <div class="icon-box" data-aos="fade-up" style="height: 500px !important; "; data-aos-delay="100">
              <div class="icon"><i class="bi bi-card-checklist"></i></div>
              <h4 class="title"><a href="">Create wordlist:</a></h4>

                <div style="text-align: left !important;">
                  <form id="myform" action="listWordLists.php" method="post">
                          <div class="form-group row">
                            <label for="input3" name="name" class="col-sm-2 col-form-label">Wordlist name:</label>
                            <div class="col-sm-10">
                              <input required class="form-control" id="input3" name="wlname" placeholder="Name">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="input4" name="description" class="col-sm-2 col-form-label">Wordlist description:</label>
                            <div class="col-sm-10">
                              <input required class="form-control" id="input4" name="wldescription" placeholder="Description">
                            </div>
                          </div>                          
                          <div class="form-group row">
                            <label for="input4" class="col-sm-2 col-form-label">Content:</label>
                            <div class="col-sm-10">
                                  <textarea name="words" id="notepad" placeholder='drag and drop valid json file or type comma separated words. Valid file contains: ["word1","word2",..."wordn"]' class="form-control" id="exampleFormControlTextarea1" rows="8"></textarea>                            
                            </div>
                          </div>
                          <fieldset class="form-group">
                            <div class="row">
                              <legend class="col-form-label col-sm-2 pt-0">Type:</legend>
                              <div class="col-sm-10">
                                <div class="form-check">
                                      <input class="form-check-input" name="visibility" checked type="checkbox" id="visi">
                                      <label class="form-check-label" for="gridCheck1">Private</label>
                                </div>
                                <div>
                                      <select class="form-select"   name="type" id="wlistoreq">
                                          <option value="stopwords">Stopwords</option>
                                          <option value="equivalences">Equivalences</option>                                          
                                      </select>

                                </div>
                              </div>
                            </div>
                          </fieldset>           
                </div> <!-- div-->
            </div> <!-- iconbox-->

            <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</form>


          </div><!-- col-->
          <div class="col">

          </div>

        </div><!-- row-->
      </div><!--container -->
    </section><!-- End Services Section -->


    <?php include 'includes/footer.php';?>


</body>
</html>

<script>

const isValidJSON = str => {
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
};


function dropfile(file) {
  var reader = new FileReader();
  reader.onload = function(e) {
    if (isValidJSON (e.target.result) ) {
      var data = JSON.parse(e.target.result);
      console.log(data);
      notepad.value = e.target.result;
    } else {
      notepad.value = "File not valid, Valid file contains: ['word1','word2',...'wordn']";
    }
  };
  reader.readAsText(file, "UTF-8");
}

notepad.ondrop = function(e) {
  e.preventDefault();
  var file = e.dataTransfer.files[0];
  dropfile(file);
};



$('#myform').submit(function() {

  var words = $('#notepad').val();
  if (isValidJSON (words) ) {
      return true; // return false to cancel form action
  }else{
      $('#notepad').val('Data not valid, please check');
      return false;
  }
});

</script>
