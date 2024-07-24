<?php
                //check POST data
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    session_start();
                    require_once ('includes/class/class.Database.php');        
                    $db = new Database('/auth/auth.db');
                    if (! $db-> validUser ($_POST['user'], $_POST['passwd'])) {
                        echo '
                            <div class="alert alert-danger" role="alert">
                                Invalid user or password
                            </div>
                        ';
                    }else{
                        $_SESSION['user'] = $_POST['user'];
                        header('Location: itmt.php');
                    }
                }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'includes/head.php';?>
  <script src="assets/vendor/jquery/jquery.min.js"></script>
</head>
<body>       

    
        <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">


        <?php

            require_once ('includes/class/class.Database.php');        
            $db = new Database('/auth/auth.db');
            if (count ($db -> fetchQuery ('SELECT * FROM logins'))==0){
                echo '
                        <div class="alert alert-danger" role="alert">
                                Database not found or empty. Please contact the administrator.
                        </div>
                ';
                exit(); 
            }
        ?>
            <div class="row d-flex justify-content-center align-items-center h-100">

            
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                <div class="row g-0">
                    <div class="col-lg-6">
                    <div class="card-body p-md-5 mx-md-4">

                        <div class="text-center">
                        <img src="./assets/img/logoitmt.png"
                            style="width: 412px; padding-bottom:50px;" alt="logo">
                        <!--  <h4 class="mt-1 mb-5 pb-1">Welcome to ITMT:</h4> -->
                        </div>

                        <form action="index.php" method="post">
                        <p>Please login to your account</p>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" id="form2Example11" name="user"  class="form-control"
                            placeholder="" required/>
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="password" id="form2Example22" name="passwd" class="form-control" required/>
                            <label class="form-label" for="form2Example22">Password</label>
                        </div>

                        <div class="text-center pt-1 mb-5 pb-1">
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="button">Login</button>
                           <!-- <a class="text-muted" href="#!">Forgot password?</a> -->
                        </div>

                        <!--
                        
                        <div class="d-flex align-items-center justify-content-center 	pb-4">
                            <p class="mb-0 me-2">Don't have an account?</p>
                            <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Create new</button>
                        </div>
                                          -->

                        </form>

                    </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                    <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                        <h4 class="mb-4">Interactive Model trainer:</h4>
                        <p class="small mb-0">Interactive Topic Model Trainer (TARS) developed within the EU-funded project IntelComp. TARS is a user-in-the-loop topic modeling tool presented with a graphical user interface that allows the training and curation of different state-of-the-art topic extraction libraries, including some recent neural-based methods, oriented toward the usage by domain experts.</p>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </section>

        
</body>
</html>

