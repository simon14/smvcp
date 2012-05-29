<?php

class CFormUserprofile extends CForm {

  /**
   * Constructor
   */
  public function __construct($object, $user) {
    parent::__construct();
    $this->AddElement(new CFormElementText('acronym', array('readonly'=>true, 'value'=>$user['akronym'], 'class'=>'field')))
         ->AddElement(new CFormElementPassword('password', array('label' => 'New password:', 'class'=>'field')))
         ->AddElement(new CFormElementPassword('password1', array('label'=>'Password again:', 'class'=>'field')))
         ->AddElement(new CFormElementSubmit('change_password', array('callback'=>array($object, 'DoChangePassword'), 'class'=>'button')))
         ->AddElement(new CFormElementText('name', array('value'=>$user['name'], 'required'=>true, 'class'=>'field')))
         ->AddElement(new CFormElementText('email', array('value'=>$user['email'], 'required'=>true, 'class'=>'field')))
         ->AddElement(new CFormElementSubmit('save', array('callback'=>array($object, 'DoProfileSave'), 'class'=>'button')));
  }
  
}