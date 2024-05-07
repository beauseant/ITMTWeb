<?php

echo '
    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex justify-content-between">

        <div class="logo">
            <h1 class="text-light"><a href="index.php">ITMT: Interactive Model Trainer</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html"><img src="assets/img/logo.jpg" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar">
            <ul>
            <li><a class="active" href="index.php">Home</a></li>
            <li class="dropdown"><a href="#"><span>Corpora</span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                <li><a href="listRawCorpora.php">Raw Corpora</a></li>
                <li><a href="listLogicalCorpora.php">Logical Corpora</a></li>
                </ul>
            </li>
            <li><a href="listmodels.php">Models</a></li>
            <li><a href="listWordLists.php">Wordlists</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->
    ';

?>