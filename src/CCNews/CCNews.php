<?php
/**
* A blog controller to display a blog-like list of all content labelled as "post".
* 
* @package SmvcCore
*/
class CCNews extends CObject implements IController {


  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }


  /**
   * Display all content of the type "post".
   */
  public function Index() {
    $content = new CMContent();
    $content = $content->GetAllFilteredData('desc');
    $gravatars=$this->user->GravatarGenerator();
    $userAuth = $this->user->IsAuthenticated();
    $contents=array();
    
    foreach($content as $val) {
	 	if($val['members']=='yes' && $userAuth) {
		    array_push($contents, $val);
		} elseif($val['members']=='no') {
			array_push($contents, $val);
		}
    }
    $this->views->SetTitle('News');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'contents' => $contents, 
                  'gravatar' => $gravatars,
                  'userId'	 => $this->user->GetId(),
                  'userWriter' => $this->user->IsWriter(),
                ));
  }


}