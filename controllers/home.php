<?php
// Path: MVC/controllers/test/home.php
class Home extends Controller
{

	public function __construct()
	{

	}
	
	public function index($properties = array())
	{
		echo '<pre>';
		print_r($properties);
		echo '</pre>';
	}
}
?>