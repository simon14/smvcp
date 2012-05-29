<?php
/**
 *	A Guestbook
 */
class CCGuestbook extends CObject implements IController {

  private $pageTitle = 'SMVC GUESTBOOK';
  private $model = null;

  /**
   * Constructor, also creating DB connection.
   */
  public function __construct() {
    parent::__construct();
    $this->model=new CMGuestBook();
    
  }
  
  /**
  *  IController interface used, Index() included.
  */
  public function Index() {   
  
    $this->views->SetTitle($this->pageTitle);
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
      'entries'=>$this->model->ReadAll(), 
      'formAction'=>$this->request->CreateUrl('guestbook/handler')
    ));
    
  }
 
  
  /**
   * Handle posts from the form and take appropriate action.
   */
  public function handler() {
    if(isset($_POST['doAdd'])) {
      
      $this->model->Add(strip_tags($_POST['newEntry']));
    }
    elseif(isset($_POST['doClear'])) {
      
      $this->model->Clear();
    }            
    elseif(isset($_POST['doCreate'])) {
      
      $this->model->CreateTableInDatabase();
    } 
    
    header('Location: ' . $this->request->CreateUrl('guestbook'));
  }

}

?>