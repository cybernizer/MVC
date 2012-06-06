<?php
// Path: MVC/controllers/controller.php
class Controller
{
	private $url = array();
	public $urlArray;
	public $controller;

	public function __construct($urlArray)
	{
		$this->urlArray = $urlArray;
	}

	//Load controller
	public function loadController()
	{
		// Check if more that the home page is in the directory
		if(is_array($this->urlArray) && count($this->urlArray) > 0)
		{
			$dirPath = CONTROLLERS_FOLDER;
			
			foreach($this->urlArray as $url)
			{
				// Check for directories
				if($this->isDirectory($url))
				{
					$dirPath .= $url . '/';
				}
				else
				{
					//If the file doesn't exsit then load the default controller
					if(!file_exists($dirPath.$url.'.php'))
					{
						// If class is set then we are up to the method
						if(isset($this->url['class']))
						{
							if(isset($this->url['method']))
							{
								// Set the properties
								$this->setProperties($url);									
							}	
							else
							{
								// Check if the method exists
								if(method_exists($this->controller, $url))
								{
									$this->url['method'] = $url;
								}
								else 
								{
									// Default method
									$this->url['method'] = DEFAULT_METHOD;
								
									// Set the properties
									$this->setProperties($url);								
								}						
							}
						}
						else
						{
							$this->setClass($dirPath);

							// Set the properties
							$this->setProperties($url);
						}
					}
					elseif($url != 'index')
					{		
						if(!isset($this->url['class']))
						{					
							$this->setClass($dirPath, $url);	
						}
					}
				}
			}

			if(!isset($this->url['controller']))
			{
				// Default controller 
				$this->setClass($dirPath);
			}
			
			if(!isset($this->url['method']))
			{
				// Default method
				$this->url['method'] = DEFAULT_METHOD;
			}

			if(!isset($this->url['properties']))
			{
				// Default properties
				$this->url['properties'] = array();
			}
			
			// Pass the properties
			$this->controller->{$this->url['method']}($this->url['properties']);			
		}
		else
		{
			// If url doesn't have an array then load the default controller, and method
			$this->setClass();
			$this->controller->{DEFAULT_METHOD}();
		}			
	}

	public function loadModel($class)
	{
		// Get the models file
		$modelFile = MODELS_PATH.$class.'.php';

		// Check If the file exsit
		if(!file_exists($modelFile))
		{
			// If the file doesn't exsit
			
		}
		else
		{
			require_once($modelFile);
			$class = "M_".ucfirst($class);
			
			$this->model = new $class();
		}
	}
	

	public function loadView($view, $properties = array())
	{
		if(count($properties) > 0)
		{
			extract($properties, EXTR_PREFIX_SAME, "v_");
		}	
		
		require_once(VIEWS_PATH.$view.'.php');		
	}
	
	public function displayMsg($view, $data)
	{
		$this->loadView($view,$data);
	}
	
	public function isDirectory($folder)
	{
		if(is_dir(CONTROLLERS_FOLDER.$folder))
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	public function setProperties($url)
	{
		$this->url['properties'][] = $url;
	}
	
	public function setClass($dirPath = CONTROLLERS_FOLDER, $class = DEFAULT_CONTROLLER)
	{
		$this->url['controllerFile'] = $dirPath.$class.".php";
		$this->url['class'] = ucfirst($class);
		
		// Load the controller
		require_once($this->url['controllerFile']);
		$this->controller = new $this->url['class'];		
	}
}
?>