<?

class CCAdminControlPanel extends CObject implements IController {

	public function __construct() {
		parent::__construct();
	}
	
	public function Index() {
		
		$this->views->SetTitle('Manage Modules');
    	$this->views->AddInclude(__DIR__ . '/index.tpl.php', array(), 'primary');
    	$this->views->AddInclude(__DIR__ . '/sidebar.tpl.php', array(), 'sidebar');
	}
	
	public function clearGuestbook() {
	
		if($this->user->IsAuthenticated()) {
      		if($this->user->IsAdministrator())
				$this->db->ExecuteQuery('TRUNCATE TABLE Guestbook;');
			else
				$this->session->AddMessage('error', 'You have to logged in as administrator.');
		}
		else
			$this->session->AddMessage('error', 'You have to logged in.');
		
		self::RedirectToController();
	}
	
	public function clearContent() {
	
		if($this->user->IsAuthenticated()) {
      		if($this->user->IsAdministrator())
				$this->db->ExecuteQuery('TRUNCATE TABLE Content;');
			else
				$this->session->AddMessage('error', 'You have to logged in as administrator.');
		}
		else
			$this->session->AddMessage('error', 'You have to logged in.');
		
		self::RedirectToController();
	}
	
	public function RedirectToController() {
		header('Location: '. $this->request->CreateUrl('acp'));
	}
	
}

?>