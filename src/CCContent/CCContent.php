<?php
/**
* A user controller to manage content.
* 
* @package SmvcCore
*/
class CCContent extends CObject implements IController {


  /**
   * Constructor
   */
  public function __construct() { parent::__construct(); }


  /**
   * Show a listing of all content.
   */
  public function Index() {
    $content = new CMContent();
    $this->views->SetTitle('Content Controller');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'contents' => $content->ListAll(),
                  'userAuth' => $this->user->IsAuthenticated(),
                  'user'     => $this->user->GetUserProfile(),
                ));
  }
  

  /**
   * Edit a selected content, or prepare to create new content if argument is missing.
   *
   * @param id integer the id of the content.
   */
  public function Edit($id=null) {
  	if($this->session->GetAuthenticatedUser()) {
    $content = new CMContent($id);
    $form = new CFormContent($content);
    $status = $form->Check();
    if($status === false) {
      $this->session->AddMessage('notice', 'The form could not be processed.');
      $this->RedirectToController('edit', $id);
    } else if($status === true) {
      $this->RedirectToController('edit', $content['id']);
    }
    
    $title = isset($id) ? 'Edit' : 'Create';
    $this->views->SetTitle("$title content: $id");
    $this->views->AddInclude(__DIR__ . '/edit.tpl.php', array(
                  'user'=>$this->user, 
                  'content'=>$content, 
                  'form'=>$form,
                ));
    } else {
    	$this->session->AddMessage('error', 'You are not logged in.  You cannot edit or create unless you are identified.');
    	$this->RedirectToController('index');
    }
  }
  

  /**
   * Create new content.
   */
  public function Create() {
    $this->Edit();
  }


  /**
   * Init the content database.
   */
  public function Init() {
    $content = new CMContent();
    $content->Init();
    $this->RedirectToController();
  }
  
  public function RedirectToController($where, $id=null){
  	 $id = isset($id) ? '/'.$id : null;
  	 header('Location: ' . $this->request->CreateUrl('content/'. $where. $id));
  }

}