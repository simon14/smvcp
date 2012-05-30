<?php


  /**
  *	Mainclass for the framework, SMVC
  */
  
class CSmvc implements ISingleton {

   private static $instance = null;

  /**
  *  Constructor, with DB-connector
  */
   protected function __construct() {
      // include the site specific config.php and create a ref to $cs to be used by config.php
      $cs = &$this;
      require(SMVC_SITE_PATH.'/config.php');
    	
    
      /**
	  *  Check if config['database'] exists and contain info
	  *  In that case, connect to that database
	  */
	  if(isset($this->config['database'][0]['dsn'])){
      	$this->db = new CMDatabase($this->config['database'][0]['dsn'], $this->config['database'][0]['usr'], $this->config['database'][0]['pass']);
      }
      
      /**
   	  * 	Viewcontainer for the methods
      */
   	  $this->views = new CViewContainer();
   	  
      // Start a named session
      session_name($this->config['session_name']);
      session_start();
      $this->session = new CSession($this->config['session_key']);
      $this->session->PopulateFromSession();
      
      // Create a object for user/**
      $this->user=new CMUser($this);
      
      
      
   }
	
   
  /**
  //	Singelton function, get last instance of itself or create a new one
  */
   public static function Instance() {
      if(self::$instance == null) {
         self::$instance = new CSmvc();
      }
      
      return self::$instance;
    }
      
  
  /**
  * 	Frontcontroller, check URL and send to correct controller
  */
  public function FrontControllerRoute() {
  
  	/**
    *	Get the URL
    */
  	$this->request = new CRequest($this->config['url_type']);
  	$this->request->Init($this->config['base_url'], $this->config['routing']);
  	$controller = $this->request->controller;
  	$method		= $this->request->method;
  	$arguments	= $this->request->arguments;
	
	
    /**
    *	Check if the controller exsists in the site/config.php file
    */
  	$controllerExists	=isset($this->config['controllers'][$controller]);
  	$controllerEnabled	=false;
  	$className			=false;
  	$classExists		=false;
  	
  	if($controllerExists){
  		$controllerEnabled	=($this->config['controllers'][$controller]['enabled']==true);
  		$className			=$this->config['controllers'][$controller]['class'];
  		$classExists		=class_exists($className);
  	}
  	


    /**
    *	Check if the controller has a matching method to call
    */
  	if($controllerExists && $controllerEnabled && $classExists) {
  	
      $rc = new ReflectionClass($className);
    
      if($rc->implementsInterface('IController')) {
        if($rc->hasMethod($method)) {
          $controllerObj = $rc->newInstance();
          $methodObj = $rc->getMethod($method);
          $methodObj->invokeArgs($controllerObj, $arguments);
        } else {
          die("404. " . get_class() . ' error: Controller does not contain method.');
        }
      } else {
        die('404. ' . get_class() . ' error: Controller does not implement interface IController.');
      }
    } else { 
      die('404. Page is not found.');
    }
    
  	// ====== Utskrift av controller, method, arguments ==========
  	/*echo "Controller: ".$controller."<br />";
  	echo "Method: ".$method."<br />";
  	foreach($arguments as $val){
  		echo $val."<br />";
  	}
  	echo "Classname: ".$className."<br />";
  	*/
  	
  	
    /**
    * Add request_uri and script_name to debug
	*/
    $this->data['debug']  = "REQUEST_URI - {$_SERVER['REQUEST_URI']}\n";
    $this->data['debug'] .= "SCRIPT_NAME - {$_SERVER['SCRIPT_NAME']}\n";
    

    /**
    *	Save the name of called class in the data-array
    */
    $this->data['selected'] = $className;
    
   }
   
   public function ThemeEngineRender(){

	global $cs;
	
   	
    /**
    *	Get path for theme to be used
    */
   	$themeName	=$this->config['theme']['name'];
   	$themePath	= SMVC_INSTALL_PATH."/themes/{$themeName}";
   	$themeUrl	= $cs->request->base_url."themes/{$themeName}";
   	
   	
    /**
    *	Get path for stylesheet
    */
    if(!isset($this->config['theme']['stylesheet'])) {
    	$this->data['stylesheet'] = "{$themeUrl}/style.css";	
   	} else {
   		$this->data['stylesheet'] = "{$themeUrl}/{$this->config['theme']['stylesheet']}";
   	}
    /**
    *	Include the functions.php and /'themepath'/functions.php for the theme
    */
   	$cs =&$this;
   	$functionsPath = "{$themePath}/functions.php";
   	if(is_file($functionsPath)){
   		include SMVC_INSTALL_PATH."/themes/function.php";
   		include $functionsPath;
   	}
   	
   	
    /**
    *	Save everything that have been modified into the session before printing the page
    */
  	$this->session->StoreInSession();
   	
   	extract($this->views->GetData());
   	extract($this->data);
   	extract($this->config);
	include("{$themePath}/default.tpl.php");
   	
   }
}
   
?>
