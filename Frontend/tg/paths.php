<?php
	// create a constant to hold the program name
	// for my local pc
	define('PROG_NAME' , 'tg');

	// get folder path, folder path is how to get back to the root / htdocs directory, through the folder structure
	define('FOLDER_DIR' , $_SERVER['DOCUMENT_ROOT'] . '/');

	// define the location of the back end lib directory
	// this is the absolute path on my local pc
	define('LIB_BACKEND_DIR' , 'D:\Work\PHP\2020\www\TG-Speed-Test\Backend\lib/');
	// relative path on the server
	//define('LIB_BACKEND_DIR' , 'backEnd/lib/');

	// define the location of the site directory
	define('SITE_DIR' , LIB_BACKEND_DIR . 'site/' . PROG_NAME . '/');

	// define the location of the API directory
	define('API_DIR' , SITE_DIR . 'API/');

	// define the location of the business directory
	define('BUSINESS_DIR' , SITE_DIR . 'business/');

	// define the location of the process directory
	define('PROCESS_DIR' , SITE_DIR . 'process/');

	// define the location of the data directory
	define('DATA_DIR' , SITE_DIR . 'data/');

	// define the location of the structure directory
	define('STRUCTURE_DIR' , SITE_DIR . 'structure/');

	// define the location of the function directory
	define('FUNCTION_DIR' , SITE_DIR . 'function/');

	// define the location of the error directory
	define('ERROR_DIR' , SITE_DIR . 'error/');
	
	// define the location of the html  directories
	define('HTML_DIR' , SITE_DIR . 'html/');

	// define the location of the php directories
	define('PHP_DIR' , SITE_DIR . 'PHP/');

	// define the location of the lib directory
	define('LIB_DIR' , '/lib/');

	// define the location of the css directory
	define('CSS_DIR' , LIB_DIR . 'css/');

	// define the location of the images directory
	define('IMAGES_DIR' , LIB_DIR . 'images/');

	// define the location of the js directory
	define('JS_DIR' , LIB_DIR . 'js/');

	// define the location of the widgets directory
	define('WIDGETS_DIR' , LIB_DIR . 'widgets/');
?>