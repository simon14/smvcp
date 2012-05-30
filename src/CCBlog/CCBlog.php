<?php
/**
* A blog controller to display a blog-like list of all content labelled as "post".
* 
* @package SmvcCore
*/
class CCBlog extends CObject implements IController {


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
    $gravatars=$this->user->GravatarGenerator();
    $this->views->SetTitle('Blog');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'contents' => $content->GetAllFilteredData('desc'), 
                  'gravatar' => $gravatars,
                  'userId'	 => $this->user->GetId(),
                  'userWriter' => $this->user->IsWriter(),
                ));
  }


}