<?php

class CCUser extends CObject implements IController{
	
	private $userModel;
	
	public function __construct() {
		
		parent::__construct();
		$this->userModel=$this->user;
	}
	
	
	public function Index() {
		
		$this->views->SetTitle('User Profile');
		$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
			'is_authenticated' => $this->userModel->IsAuthenticated(),
			'user' => $this->userModel->GetUserProfile(),
		));
	}
	
	public function login($akronymOrEmail=null, $password=null) {

	if($this->user->IsAuthenticated()) {
		
		$this->views->SetTitle('Login');
	    $this->views->AddInclude(__DIR__ . '/logout.tpl.php', array());
		
	} else {
	
		$form = new CFormUserLogin($this);
		$form->Check();
		
	    $this->views->SetTitle('Login');
	    $this->views->AddInclude(__DIR__ . '/login.tpl.php', array('login_form'=>$form->GetHTML()));
	}
	
	}
	
	public function DoLogin($form) {
	
    if($this->user->Login($form['acronym']['value'], $form['password']['value'])) {//$form->GetValue('acronym'), $form->GetValue('password'))) {	//$name, $pass)) {
      	$this->RedirectToController('profile');
    } else {
     	 $this->RedirectToController('login');      
    	}
    }
	
	public function logout() {
	
			$this->userModel->LogOut();
			$this->RedirectToController();
		
	}
	
	
	
	private function RedirectToController($where=null) {
	
		header('Location: ' . $this->request->CreateUrl('user/'. $where));
	}
	
	public function profile() {

		
		 $form = new CFormUserprofile($this, $this->user);
    	 $form->Check();

    	 $this->views->SetTitle('User Profile');
         $this->views->AddInclude(__DIR__ . '/profile.tpl.php', array(
				  'is_authenticated'=>$this->user['isAuthenticated'], 
                  //'user'=>$this->user,
                  'profile_form'=>$form->GetHTML(),
                  'gravatar' => $this->userModel->getGravatar(),
                ));
    }
    
    /**
    * Change the password.
    */
  	public function DoChangePassword($form) {
    	
    	if($form['password']['value'] != $form['password1']['value'] || empty($form['password']['value']) || empty($form['password1']['value'])) {
      	$this->session->AddMessage('error', 'Password does not match or is empty.');
	    } else {
    	  $ret = $this->user->ChangePassword($form['password']['value']);
      	  $this->session->AddMessage($ret, 'Saved new password.', 'Failed updating password.');
    	}
    	
    	$this->RedirectToController('profile');
  	}
  	
  	/**
   	* Save updates to profile information.
   	*/
  	public function DoProfileSave($form) {
    
    	$this->user['name'] = $form['name']['value'];
	    $this->user['email'] = $form['email']['value'];
    	$ret = $this->user->Save();
	    $this->session->AddMessage($ret, 'Saved profile.', 'Failed saving profile.');
	    $this->RedirectToController('profile');
  	}
  	
  	/**
   	* Create a new user.
   	*/
  	public function Create() {
    	$form = new CFormUserCreate($this);
	    if($form->Check() === false) {
    	  $this->session->AddMessage('notice', 'You must fill in all values.');
      	  $this->RedirectToController('Create');
   		}
    	$this->views->SetTitle('Create user');
        $this->views->AddInclude(__DIR__ . '/create.tpl.php', array('form' => $form->GetHTML()));     
  	}
  	
   /**
   * Perform a creation of a user as callback on a submitted form.
   *
   * @param $form CForm the form that was submitted
   */
   public function DoCreate($form) {    
     if($form['password']['value'] != $form['password1']['value'] || empty($form['password']['value']) || empty($form['password1']['value'])) {
       $this->session->AddMessage('error', 'Password does not match or is empty.');
       $this->RedirectToController('create');
     } else if($this->user->Create($form['acronym']['value'], 
                            $form['password']['value'],
                            $form['name']['value'],
                            $form['email']['value']
                            )) {
       $this->session->AddMessage('success', "Welcome {$this->user['name']}. Your have successfully created a new account.");
       $this->user->Login($form['acronym']['value'], $form['password']['value'], true);
       $this->RedirectToController('profile');
     } else {
       $this->session->AddMessage('notice', "Failed to create an account.");
       $this->RedirectToController('create');
     }
    }
    
    public function salthash($pass="abc") {
    	$newpass=$this->userModel->CreatePassword($pass);
    	$this->views->SetTitle('Password Debug');
	    $this->views->AddInclude(__DIR__ . '/password.tpl.php', array('pass'=>$newpass['password'], 'salt'=>$newpass['salt'], 'realpass'=>$pass));
    }

   }

?>