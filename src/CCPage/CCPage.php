<?php
/**
* A page controller to display a page, for example an about-page, displays content labelled as "page".
* 
* @package SmvcCore
*/
class CCPage extends CObject implements IController {


  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }


  /**
   * Display an empty page.
   */
  public function Index() {
    $content = new CMContent();
    
    $this->views->SetTitle('Page');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'content' => null,
                ));
  }
  
  /**
   * Display a page.
   *
   * @param $id integer the id of the page.
   */
  public function View($id=null) {
    $content = new CMContent($id);
    $content->FilterContent();
    
    $comment = new CMComment($id);
    
    $this->views->SetTitle('Page: '.$content['title']);
	$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'content' => $content,
                  'entries'=>$comment->ReadAll(), 
			      'formAction'=>$this->request->CreateUrl("page/handler/{$id}"),
			      'user'=>$this->user,
			      'userWriter'=>$this->user->IsWriter(),
			      
                ), 'primary');
	$this->views->AddInclude(__DIR__.'/sidebar.tpl.php', array(
				  'nextNews'=>$content->GoNextNews(),
			      'backNews'=>$content->GoBackNews(),
			      'news'=>$content['type']=='news',
			      ), 'sidebar');
  }
  
  /**
   * Restore deleted a page.
   *
   * @param $id integer the id of the page.
   */
  public function Restore($id=null) {
    
    if($this->user->IsAdministrator()){
        $content = new CMContent($id);
    	$content->Restore();
    }
    
    $this->RedirectToController('content/restore');
  }
  
  /**
   * Like a page.
   *
   * @param $id integer the id of the page.
   */
  public function Like($id=null) {
    
    $content = new CMContent($id);
 	$content->Like();
    
  	Header('Location:'.$_SESSION['lastPage']);  
  }
  
  public function Delete($id=null, $where=null) {
  		$content = new CMContent();
	  	$content->Delete($id);
	  	self::RedirectToController($where);
	  	
  }
	
  public function RedirectToController($where) {
  		header('Location: ' . $this->request->CreateUrl($where));
  }
  
  public function handler($id=null) {
  	
  	$comment = new CMComment($id);
  	
    if(isset($_POST['doAdd'])) {
      
      $comment->Add(strip_tags($_POST['newEntry']), $_POST['userId']);
    }
    elseif(isset($_POST['doClear'])) {
      
      $comment->Clear();
    }            
    elseif(isset($_POST['doCreate'])) {
      
      $comment->CreateTableInDatabase();
    } 
    
    header('Location: ' . $this->request->CreateUrl("page/view/{$id}"));
  }

}