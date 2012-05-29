<?php

  /**
  *	Session-manager
  */
  
class CSession {

  /**
   * Members
   */
  private $key;
  private $data = array();
  private $flash = null;
   

  /**
   * Constructor
   */
  public function __construct($key) {
    $this->key = $key;
  }


  /**
   * Set values
   */
  public function __set($key, $value) {
    $this->data[$key] = $value;
  }


  /**
   * Get values
   */
  public function __get($key) {
    return isset($this->data[$key]) ? $this->data[$key] : null;
  }
  
  public function __unset($key) {
  	unset($this->data[$key]);
  }


  /**
   * Set flash values, to be remembered one page request
   */
  public function SetFlash($key, $value) {
    $this->data['flash'][$key] = $value;
  }


  /**
   * Get flash values, if any.
   */
  public function GetFlash($key) {
    return isset($this->flash[$key]) ? $this->flash[$key] : null;
  }


  /**
   * Add message to be displayed to user on next pageload. Store in flash.
   *
   * @param $type string the type of message, for example: notice, info, success, warning, error.
   * @param $message string the message.
   */
  public function AddMessage($type, $message) {
    $this->data['flash']['messages'][] = array('type' => $type, 'message' => $message);
  }


  /**
   * Get messages, if any. Each message is composed of a key and value. Use the key for styling.
   *
   * @returns array of messages. Each array-item contains a key and value.
   */
  public function GetMessages() {
    return isset($this->flash['messages']) ? $this->flash['messages'] : null;
  }


  /**
   * Store values into session.
   */
  public function StoreInSession() {
    $_SESSION[$this->key] = $this->data;
  }


  /**
   * Store values from this object into the session.
   */
  public function PopulateFromSession() {
    if(isset($_SESSION[$this->key])) {
      $this->data = $_SESSION[$this->key];
      if(isset($this->data['flash'])) {
        $this->flash = $this->data['flash'];
        unset($this->data['flash']);
      }
    }
  }
  
  /*============================
  //	Set authenticated user
  //===========================*/
  public function SetAuthenticatedUser($user) {
  	self::__set('user', $user);
  }
  
  /*============================
  //	Check if user is authenticated
  //===========================*/
  public function GetAuthenticatedUser() {
  	return self::__get('user');
  }
  
  public function UnsetAuthenticatedUser() {
  	self::__unset('user');
  }

}

?>