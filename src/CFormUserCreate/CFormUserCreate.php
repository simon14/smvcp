<?php
/**
* A form for creating a new user.
* 
* @package SmvcCore
*/
class CFormUserCreate extends CForm {

  /**
   * Constructor
   */
  public function __construct($object) {
    parent::__construct();
    $this->AddElement(new CFormElementText('acronym', array('required'=>true, 'class'=>'field')))
         ->AddElement(new CFormElementPassword('password', array('required'=>true, 'class'=>'field')))
         ->AddElement(new CFormElementPassword('password1', array('required'=>true, 'label'=>'Password again:', 'class'=>'field')))
         ->AddElement(new CFormElementText('name', array('required'=>true, 'class'=>'field')))
         ->AddElement(new CFormElementText('email', array('required'=>true, 'class'=>'field')))
         ->AddElement(new CFormElementSubmit('create', array('callback'=>array($object, 'DoCreate'), 'class'=>'button')));
         
    $this->SetValidation('acronym', array('not_empty'))
         ->SetValidation('password', array('not_empty'))
         ->SetValidation('password1', array('not_empty'))
         ->SetValidation('name', array('not_empty'))
         ->SetValidation('email', array('not_empty'));
  }
  
}