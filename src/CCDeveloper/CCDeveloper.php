<?php
/**
*	Developer helpstuff
*/
class CCDeveloper extends CObject implements IController {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function Index() {
		$this->views->SetTitle('Developer Index');
		$this->views->AddInclude(__DIR__. '/index.tpl.php', array('menu' => $this->Menu(), 'baseurl' => $this->request->base_url));
	
	}
	
	public function links() {
	
		
		$testLinks = array(
		'clean' => array('url' => $this->request->base_url.'developer/links', 'name' => "developer/links", 'type' => "Clean"),
		'normal' => array('url' => $this->request->base_url.'index.php/developer/links', 'name' => "index.php/developer/links", 'type' => "Normal"),
		'query' => array('url' => $this->request->base_url.'index.php?q=developer/links', 'name' => "index.php?q=developer/links", 'type' => "Query"),
		);
		
		$outLinks = '<h3> Some different kind of links </h3>';
		foreach($testLinks as $key){
			$outLinks.="{$key['type']} - <a href='{$key['url']}'>{$key['name']}</a><br />";
		}
		
		$this->views->SetTitle('Developer Links');
		$this->views->AddInclude(__DIR__. '/index.tpl.php', array('menu' => $this->Menu(), 'extra' => $outLinks, 'baseurl' => $this->request->base_url));
		
	}
	
	
	/**
	* Display all items of the CObject.
	*/
	public function displayObjects() {	
	
		$dump = <<<EOD
		<h2>Dumping content of CDeveloper</h2>
		<p>Here is the content of the controller, including properties from CObject which holds access to common resources in Smvc.</p>
EOD;
		$dump .= '<pre>' . htmlentities(print_r($this, true)) . '</pre>';
		
		$this->views->SetTitle('Developer ObjectDump');
		$this->views->AddInclude(__DIR__. '/index.tpl.php', array('menu' => $this->Menu(), 'baseurl' => $this->request->base_url, 'extra' => $dump));
		
	}
	
	private function Menu() {
		$items = array();
				
				$key = 'developer';
        		$rc = new ReflectionClass('CCDeveloper');
		        $items[] = $key;
		        $methods = $rc->getMethods(ReflectionMethod::IS_PUBLIC);
		        
			    foreach($methods as $method) {
    			      if($method->name != '__construct' && $method->name != '__destruct' && $method->name != 'Index') {
			            $items[] = "{$key}/" . mb_strtolower($method->name);
      				  }    
      			}
      		
    
    	return $items;
	}

}

?>