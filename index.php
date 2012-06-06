<?php
// Path: freakyfree.com/index.php
/*
echo '<pre>';
print_r($uri_array);
echo '</pre>';
*/

$debug = true;

if($debug)
{
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}
else
{
	error_reporting(0);
	ini_set('display_errors', '0');
}

// include(dirname(__FILE__).'/define/define.php');

###################################################################################
#			MAKE SURE THEY ARE DEFINED AND MAKE SURE THAT THE DEFINES EXISTS
###################################################################################
// Define server path
define('SERVER_ROOT' , dirname(__FILE__).'/');

// Define site path
define('SITE_ROOT' , 'http://yoursite.com');

// Define controllers folder path
define('CONTROLLERS_FOLDER', SERVER_ROOT.'controllers/');

// Define default controllor
define('DEFAULT_CONTROLLER', 'home');

// Define default method
define('DEFAULT_METHOD', 'index');

// Define methods folder path
define('METHODS_FOLDER', SERVER_ROOT.'methods/');

// Define views folder path
define('VIEWS_FOLDER', SERVER_ROOT.'views/');
###################################################################################

// Get the initial URL
$url = $_SERVER['REQUEST_URI'];

// Create an array from the URL
$urlArray = preg_split('[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY);

// Get Controller
require_once(CONTROLLERS_FOLDER."controller.php");
	
// Load Controller
$controller = new Controller($urlArray);
$controller->loadController();
?>