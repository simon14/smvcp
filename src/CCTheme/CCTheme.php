<?php
/**
* A test controller for themes.
* 
* @package SmvcCore
*/
class CCTheme extends CObject implements IController {


  /**
   * Constructor
   */
  public function __construct() { 
  	parent::__construct(); 
    $this->views->AddStyle('body:hover{background:#fff url('.$this->request->base_url.'themes/grid/grid_12_60_20.png) repeat-y center top;}');
  }


  /**
   * Display what can be done with this controller.
   */
  public function Index() {
    $this->views->SetTitle('Theme');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'theme_name' => $this->config['theme']['name'],
                ));
  }
	
  /**
   * Put content in some regions.
   */
  public function SomeRegions() {
    $this->views->SetTitle('Theme display content for some regions');
    $this->views->AddString('This is the primary region', array(), 'primary');
                
    if(func_num_args()) {
      foreach(func_get_args() as $val) {
        $this->views->AddString("This is region: $val", array(), $val);
        $this->views->AddStyle('#'.$val.'{background-color:hsla(0,0%,90%,0.5);}');
      }
    }
  }
  
  /**
   * Put content in all regions.
   */
  public function AllRegions() {
    $this->views->SetTitle('Theme display content for all regions');
    
    foreach($this->config['theme']['regions'] as $val) {
      $this->views->AddString("This is region: $val", array(), $val);
      $this->views->AddStyle('#'.$val.'{background-color:hsla(0,0%,90%,0.5);}');
    }
  }
  
  public function H1h6() {
    $this->views->SetTitle('Test h1h6');
    $this->views->AddInclude(__DIR__ . '/h1h6.tpl.php', array());
  }

}