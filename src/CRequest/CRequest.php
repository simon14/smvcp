<?php

  /**
  * 	Request
  * 	Manages request from the URL
  * 	And create url's for links
  */
  
class CRequest {

	public $cleanUrl;
	public $querystringUrl;
	
	public function __construct($urlType=0) {
		$this->cleanUrl			= $urlType==1 ? true : false;
		$this->querystringUrl	= $urlType==2 ? true : false;
		
	}
	
	public function Init($baseUrl = null) {
	
		// Prepare to create current_url and base_url
	  	  $currentUrl 	= $this->GetCurrentUrl();
	      $parts        = parse_url($currentUrl);
	    
	    // If base_url is not set in config.php, autogenerate it
	    if(empty($baseUrl)){
	      $baseUrl      = !empty($baseUrl) ? $baseUrl : "{$parts['scheme']}://{$parts['host']}" . (isset($parts['port']) ? ":{$parts['port']}" : '') . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
		}
    
     
    	$requestUri = $_SERVER['REQUEST_URI'];
	    $scriptName = $_SERVER['SCRIPT_NAME']; 
    
		/* Take current url and divide it in controller, method and arguments
    	 * Check if the URL is a querystring ('?q=controller/method')
    	 * In that case only use whats after '?q='
    	 * Else pick the whole URL
    	 */
    	if(isset($_GET['q'])){
      		$query = $_GET['q'];
      	} else {
			$query = substr($_SERVER['REQUEST_URI'], strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '/')));
      	}
      		
      	// Split the query
	   	$splits = explode('/', trim($query, '/'));
	   		

	   	if(!empty($splits[0])&&!isset($_GET['q'])){
				
			// Check if query is defualt ('index.php/controller/method')
			$cotains=strrpos($splits[0], '.php');
			
		   	// Incase query is default ('index.php/controller/method')
		   	// Rearrange the array a bit
	   		if($cotains!==false){
	   				
	   			for($i=0; $i<sizeof($splits)-1; $i++){	
	   				$splits[$i]=$splits[$i+1];
	   			}
	   			
	   			unset($splits[sizeof($splits)-1]);
	   		}
	   			
	   	}
    	
	    // Set controller, method and arguments
	    $controller =  !empty($splits[0]) ? $splits[0] : 'index';
	    $method       =  !empty($splits[1]) ? $splits[1] : 'index';
	    $arguments = $splits;
	    unset($arguments[0], $arguments[1]); // remove controller & method part from argument list
    
  	
	    // Store it
	    $this->base_url     = rtrim($baseUrl, '/') . '/';
  	  	$this->current_url  = $currentUrl;
    	$this->request_uri  = $requestUri;
    	$this->script_name  = $scriptName;
    	$this->request      = !empty($request) ? $request : "";
    	$this->query      	= !empty($query) ? $query : "";
	    $this->splits       = $splits;
	    $this->controller   = $controller;
	    $this->method      	= $method;
	    $this->arguments    = $arguments;
    
	}
	
	public function GetCurrentUrl() {
	
   		$url = "http";
	    $url .= (@$_SERVER["HTTPS"] == "on") ? 's' : '';
    	$url .= "://";
	    $serverPort = ($_SERVER["SERVER_PORT"] == "80") ? '' :
    	(($_SERVER["SERVER_PORT"] == 443 && @$_SERVER["HTTPS"] == "on") ? '' : ":{$_SERVER['SERVER_PORT']}");
	    $url .= $_SERVER["SERVER_NAME"] . $serverPort . htmlspecialchars($_SERVER["REQUEST_URI"]);
    	
    	return $url;
  	}
	
	public function CreateUrl($url=null) {
		    
		    $prepend = $this->base_url;
		    if($this->cleanUrl) {
		    ;
		    } elseif ($this->querystringUrl) {
		    	$prepend .= 'index.php?q=';
		    } else {
    		  	$prepend .= 'index.php/';
	    	}
    		
    		return $prepend . rtrim($url, '/');
	}
}



?>