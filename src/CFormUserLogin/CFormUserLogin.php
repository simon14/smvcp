<?php
/**
 * A form to login the user profile.
 * 
 * @package SmvcCore
 */
class CFormUserLogin extends CForm {

  /**
   * Constructor
   */
  public function __construct($object) {
    parent::__construct();
    $this->AddElement(new CFormElementText('acronym', array('class'=>'field')))
         ->AddElement(new CFormElementPassword('password', array('class'=>'field')))
         ->AddElement(new CFormElementSubmit('login', array('callback'=>array($object, 'DoLogin'), 'class'=>'button')));
         
    $this->SetValidation('acronym', array('not_empty'));
    $this->SetValidation('password', array('not_empty'));
  }
  
}

?>