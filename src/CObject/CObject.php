<?php

  /**
  *	Holding a instance of SMVC
  * 	To be included by classes who need access to SMVC-class
  */

class CObject {

   public $config;
   public $request;
   public $data;
   public $db;
    
   protected function __construct($cs=null) {
    if(!$cs) {
    	$cs = CSmvc::Instance();
    }
    $this->config   = &$cs->config;
    $this->request  = &$cs->request;
    $this->data     = &$cs->data;
    $this->db		= &$cs->db;
    $this->views	= &$cs->views;
    $this->session	= &$cs->session;
    $this->user		= &$cs->user;
  }

}

?>