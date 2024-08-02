<?php include 'includes/session.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php';?>

  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
<style>

        div.scroll {
            margin: 4px, 4px;
            padding: 4px;
            background-color: #747774;
            color:#efefef;
            width: 500px;
            height: 510px;
            overflow-x: hidden;
            overflow-y: auto;
            text-align: justify;
        }
    </style>

</head>

<body>

  <?php include 'includes/topbar.php';?>
  <?php include 'includes/header.php';?>

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>About</h2>
          <ol>
            <li><a href="itmt.php">Home</a></li>
            <li>About</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= About Us Section ======= -->
    <section id="about-us" class="about-us">
      <div class="container">

        <div class="row no-gutters">
          <div class=" col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start" data-aos="fade-right">
              <div class="embed-responsive embed-responsive-1by1">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/taCifpq-IZI?si=NdC23mDux02l40sV" allowfullscreen></iframe>
            </div>  

          </div>
          <div class="col-xl-7 ps-0 ps-lg-5 pe-lg-1 d-flex align-items-stretch">
            <div class="content d-flex flex-column justify-content-center">
              <h3 data-aos="fade-up">Voluptatem dignissimos provident quasi</h3>
              <p data-aos="fade-up">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
              </p>
              <div class="row">
                <div class="col-md-6 icon-box" data-aos="fade-up">
                  <i class="bx bx-receipt"></i>
                  <h4>Corporis voluptates sit</h4>
                  <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-cube-alt"></i>
                  <h4>Ullamco laboris nisi</h4>
                  <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <i class="bx bx-images"></i>
                  <h4>Labore consequatur</h4>
                  <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                  <i class="bx bx-shield"></i>
                  <h4>Beatae veritatis</h4>
                  <p>Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta</p>
                </div>
              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->



  </main><!-- End #main -->




  <?php include 'includes/footer.php';?>


</body>

</html>