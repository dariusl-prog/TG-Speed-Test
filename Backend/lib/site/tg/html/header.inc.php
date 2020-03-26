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
    <!--<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="lib/css/home.css">
    <!-- <link rel="stylesheet" href="assets/css/fontawesome.css"> -->
    <!-- JS to include  -->
    <?php
        if ('y' == $includeJS_frontend) 
        {
            echo '<script type="text/javascript" src="' . WIDGETS_DIR . 'jQuery/jQuery.min.js"></script>';
            echo '<script type="text/javascript" src="' . JS_DIR . 'masterArray.js"></script>';
            echo '<script type="text/javascript" src="' . JS_DIR . 'speed_frontend.js"></script>';
        }
    ?>
        
    <?php
        if ('y' == $includeJS_Random_Index) 
        {
            echo '<script type="text/javascript" src="' . JS_DIR . 'Random_Number.js"></script>';  
        }
    ?>
    
    


</head>
  	<body>
  		<div> 
			<header class="site-header">
				<h1>Timeguard</h1>
				<span><h4>speed test</h4><a href="index.php"><h3>Home</h3></a></span>
			</header>
		</div>