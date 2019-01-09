<?php # Script 18.5 - index.php
// This is the main page for the site.

// Include the configuration file:
require ('includes/config.inc.php'); 

// Set the page title and include the HTML header:
$page_title = 'Home';
include ('includes/header.html');


?>

    

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">About
                    <small>Azteka</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <li class="active">About</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Intro Content -->
        <div class="row">
            <div class="col-md-6">
                <img class="img-responsive" src="images/about.jpg" alt="Books">
            </div>
            <div class="col-md-6">
                <!-- <h2>About Azteka</h2> -->
                <p>
                    Throughout the world, we provide scientific and professional communities with superior specialist information – produced by authors and colleagues across cultures in a nurtured collegial atmosphere of which we are justifiably proud.
                </p>
                <p>
                    ABCorp.com was founded after Azalea Young had an unsatisfying traditional publishing experience with his book Under the Radar, which was based on his success as the co-founder of Red Hat (NYSE: RHT). Azalea was determined to establish a more effective and profitable route to publishing. This remains a core tenet of ABCorp.com's mission -- making content creation and consumption a simpler and more rewarding experience for people around the world.
                </p>
                <p>
                    We think ahead, move fast and promote change: creative business models, inventive products, and mutually beneficial international partnerships have established us as a trusted supplier and pioneer in the information age.
                </p>
            </div>
        </div>
        
        <hr>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


<?php

 include ('includes/footer.html'); ?>