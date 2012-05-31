<?php
/**
* A form to manage content.
* 
* @package SmvcCore
*/
class CFormContent extends CForm {

  /**
   * Properties
   */
  private $content;

  /**
   * Constructor
   */
  public function __construct($content) {
    parent::__construct();
    $this->content = $content;
    $save = isset($content['id']) ? 'save' : 'create';
    $this->AddElement(new CFormElementText('title', array('value'=>$content['title'], 'class' => 'field')))
	     ->AddElement(new CFormElementTextarea('short', array('label'=>'Short description, max 30 words:', 'value'=>$content['short'], 'class' => 'textarea')))
      //   ->AddElement(new CFormElementText('type', array('value'=>$content['type'])))
         ->AddElement(new CFormElementTextarea('content', array('label'=>'Content:', 'value'=>$content['content'])))
         ->AddElement(new CFormElementText('image', array('value'=>$content['image'], 'class' => 'field')))
         ->AddElement(new CFormElementText('img', array('label'=>'Thumbnail image', 'value'=>$content['img'], 'class' => 'field')))
        // ->AddElement(new CFormElementText('filter', array('value'=>$content['filter'])))
         ->AddElement(new CFormElementDropdown('type', array('label'=>'Type:', 'values'=>array('blog', 'page', 'news'), 'selected'=>$content['type'], 'class' => 'drop')))
         ->AddElement(new CFormElementDropdown('filter', array('label'=>'Filter:', 'values'=>array('plain', 'html', 'bbcode', 'htmlpurify'), 'selected'=>$content['filter'], 'class' => 'drop')))
         ->AddElement(new CFormElementDropdown('members', array('label'=>'Members only:', 'values'=>array('no', 'yes'), 'selected'=>$content['members'], 'class' => 'drop')))
         ->AddElement(new CFormElementSubmit($save, array('callback'=>array($this, 'DoSave'), 'class' => 'button')));//, 'callback-args'=>array($this->content))));

    $this->SetValidation('title', array('not_empty'));
  }
  

  /**
   * Callback to save the form content to database.
   */
  public function DoSave($form, $content=null) {
    $content['id']    		= $form['id']['value'];
    $content['title'] 		= $form['title']['value'];
    $content['short']   	= $form['short']['value'];
    $content['type']  		= $form['type']['value'];
    $content['content']  	= $form['content']['value'];
    $content['image'] 		= $form['image']['value'];
    $content['img'] 		= $form['img']['value'];
    $content['filter']		= $form['filter']['value'];
	$content['members'] 	= $form['members']['value'];
    
    return $this->content->Save($content);
  }
  
  
}

/**' Läger hit en fetekommetar */