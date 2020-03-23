<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/paths.php');
	
	require_once(LIB_BACKEND_DIR . '/processing/bl/speed.bl.php');
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">

    <title>Timeguard Speedtest Results</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-host-cloud.css">
    <link rel="stylesheet" href="assets/css/owl.css">

</head>
	
  <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    
    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="index.php"><h2>Timeguard <em>speedtest results</em></h2></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>              
            </ul>
          </div>         
        </div>
      </nav>
    </header>

<!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="banner">
      <div class="container">
        <div class="row">
          <div class="col-md-8 offset-md-2">
            <div class="header-text caption">
              <h2><?php
              		echo 'Simple SQL : '. $simple_sql/1e+6 . '<br />';			                	
					echo 'Simple Proc : '. $simple_proc/1e+6 . '<br />';
					echo '---------<br />';
					echo 'SQL : '. $sql/1e+6 . '<br />';
					echo 'Proc : '. $proc/1e+6 . '<br />';
					echo '---------<br />';
					echo 'Loops : '. $iLoops;
				?></h2>
				<div>
					<input type="button" class="main-button" value="Re-Run" onClick="window.location.reload();" />
                         <button value="Back" onclick="window.location.href = 'index.php'">
	                     Back	
						</button>
				</div>				       
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <!-- Banner Ends Here -->

			<footer>
      			<div class="container">
        			<div class="row">
          				<div class="col-md-3 col-sm-6 col-xs-12">
            				<div class="footer-item">
              					<div class="footer-heading">
                				<h2>About :</h2>
              					</div>
              						<p>This is a site to test the speed between SQL Procedures and running a SQL script within PHP.</p>
            				</div>
          				</div>
                    <div class="col-md-12">
            	<div class="sub-footer">
              		<p>Designed by Daniel &amp; Darius</p>
            	</div>
          		</div>
        		</div>
      			</div>
    		</footer>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/accordions.js"></script>
	</body>
</html>
