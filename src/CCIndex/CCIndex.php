<?php
/**
* Index
*/
class CCIndex extends CObject implements IController {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function Index() {
	
		Header('Location: '.$this->request->CreateUrl('news'));
	
	/*	$this->views->SetTitle('Index controller');
		$this->views->AddInclude(__DIR__. '/index.tpl.php', array('menu'=>$this->Menu()), 'primary');*/
	}
	
	public function arg1() {
		$this->views->SetTitle('Index controller: Arg1');
		$this->views->AddInclude(__DIR__. '/index.tpl.php', array('menu'=>$this->Menu()));
		
	}
	
	private function Menu() {
		$items = array();
		
    	foreach($this->config['controllers'] as $key => $val) {
    	
    		if($val['enabled']) {
        		$rc = new ReflectionClass($val['class']);
		        $items[] = $key;
		        $methods = $rc->getMethods(ReflectionMethod::IS_PUBLIC);
		        
			    foreach($methods as $method) {
    			      if($method->name != '__construct' && $method->name != '__destruct' && $method->name != 'Index') {
			            $items[] = "$key/" . mb_strtolower($method->name);
      				  }    
      			}
      		}
    	}
    
    	return $items;
	}

}

?>