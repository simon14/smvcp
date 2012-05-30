<?php
/**
*	User-model, manages login requests etc
*/
class CMUser extends CObject implements IHasSQL, ArrayAccess, IModule {


	public $profile = array();
	 
	public function __construct($cs=null) {
		parent::__construct($cs);
		$profile = $this->session->GetAuthenticatedUser();
	    $this->profile = is_null($profile) ? array() : $profile;
    	$this['isAuthenticated'] = is_null($profile) ? false : true;
	}
	
  /**
   *	Implementing IModule for installation
   */
   public function Manage($action=null){
   		
   		switch($action){
   			
   			case 'install':
   				
   				try {
          			$this->db->ExecuteQuery(self::SQL('drop table user2group'));
          			$this->db->ExecuteQuery(self::SQL('drop table group'));
          			$this->db->ExecuteQuery(self::SQL('drop table user'));
		          	$this->db->ExecuteQuery(self::SQL('create table user'));
          			$this->db->ExecuteQuery(self::SQL('create table group'));
          			$this->db->ExecuteQuery(self::SQL('create table user2group'));
          			$this->db->ExecuteQuery(self::SQL('insert into user'), array('anonomous', 'Anonomous, not authenticated', null, null, null, date('c')));
          			$password = $this->CreatePassword('root');
          			$this->db->ExecuteQuery(self::SQL('insert into user'), array('root', 'The Administrator', 'root@dbwebb.se', $password['password'],  $password['salt'], date('c')));
          			$idRootUser = $this->db->LastInsertId();
          			$password = $this->CreatePassword('doe');
          			$this->db->ExecuteQuery(self::SQL('insert into user'), array('doe', 'John/Jane Doe', 'doe@dbwebb.se', $password['password'],  $password['salt'], date('c')));
          			$idDoeUser = $this->db->LastInsertId();
          			$password = $this->CreatePassword('writer');
          			$this->db->ExecuteQuery(self::SQL('insert into user'), array('writer', 'Man/Woman Writer', 'writer@dbwebb.se', $password['password'],  $password['salt'], date('c')));
          			$idWriterUser = $this->db->LastInsertId();
          			$this->db->ExecuteQuery(self::SQL('insert into group'), array('admin', 'The Administrator Group'));
          			$idAdminGroup = $this->db->LastInsertId();
          			$this->db->ExecuteQuery(self::SQL('insert into group'), array('user', 'The User Group'));
          			$idUserGroup = $this->db->LastInsertId();
          			$this->db->ExecuteQuery(self::SQL('insert into group'), array('writer', 'The Writer Group'));
          			$idWriterGroup = $this->db->LastInsertId();
          			$this->db->ExecuteQuery(self::SQL('insert into user2group'), array($idRootUser, $idAdminGroup));
          			$this->db->ExecuteQuery(self::SQL('insert into user2group'), array($idRootUser, $idUserGroup));
          			$this->db->ExecuteQuery(self::SQL('insert into user2group'), array($idDoeUser, $idUserGroup));
          			$this->db->ExecuteQuery(self::SQL('insert into user2group'), array($idWriterUser, $idWriterGroup));


		          	return array('success', 'Successfully created the database tables and created a default admin user as root:root and an ordinary user as doe:doe.');

		        } catch(Exception$e) {
        		
        		    die("$e<br/>Failed to open database: " . $this->config['database'][0]['dsn']);
        		} 
   				
   			break;
   			
   			case 'clear':
   				$this->Manage('install');
   			break;
   		}   	
   }
	
   /**
    * Implementing ArrayAccess for $this->profile
    */
    public function offsetSet($offset, $value) { if (is_null($offset)) { $this->profile[] = $value; } else { $this->profile[$offset] = $value; }}
    public function offsetExists($offset) { return isset($this->profile[$offset]); }
    public function offsetUnset($offset) { unset($this->profile[$offset]); }
    public function offsetGet($offset) { return isset($this->profile[$offset]) ? $this->profile[$offset] : null; }
	
	/**
	*	SQL, predefined sql-queries
	*/
	public static function SQL($key=null) {
		
		$queries = array ( 
			'drop table user2group'	  => 'drop table User2Groups',
			'drop table group'		  => 'drop table Groups',
			'drop table user'		  => 'drop table User',
			'create table user'		  => "CREATE TABLE `User` (
										`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
										`akronym` varchar(12) DEFAULT '',
										`name` text,
										`email` text,
										`password` text,
										`salt` text,
										`theme` varchar(10) DEFAULT NULL,
										`created` datetime DEFAULT NULL,
										`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
										PRIMARY KEY (`id`),
										UNIQUE KEY `AKRONYM` (`akronym`)
							 	  		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
			'create table user2group' => "CREATE TABLE `User2Groups` (  `idUser` int(11) NOT NULL DEFAULT '0',  `idGroups` int(11) NOT NULL DEFAULT '0',  `created` datetime DEFAULT NULL,  PRIMARY KEY (`idUser`,`idGroups`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
			'create table group'	  => "CREATE TABLE `Groups` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `akronym` text,  `name` text,  `created` datetime DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
			'insert into user' 		  => 'INSERT INTO User (akronym, name, email, password, salt, created) VALUES (?,?,?,?,?,?);',
			'check user password' 	  => "SELECT * FROM User WHERE akronym=? OR email=?;",
      		'insert into group'       => "INSERT INTO Groups (akronym,name) VALUES (?,?);",
      		'insert into user2group'  => "INSERT INTO User2Groups (idUser,idGroups) VALUES (?,?);",
      		'get group memberships'   => "SELECT * FROM Groups AS g INNER JOIN User2Groups AS ug ON g.id=ug.idGroups WHERE ug.idUser=?;",
      		'update profile'		  => "UPDATE User SET name = ?, email = ?  WHERE id = ?;",
      		'update password'		  => "UPDATE User SET password = ?, salt = ? WHERE id = ?;",
      		'get all'				  => "SELECT * FROM User;",
      		'delete user'			  => "DELETE FROM User WHERE id=?;",
			'get groups'			  => "SELECT * FROM Groups;",
		);
		
		if(!isset($queries[$key])) {
			throw new Exception("No such SQL query, key '$key' was not found.");
		}
		
		return $queries[$key];
	}
	
	/**
	*	Init, create tables in DB needed for user-managment
	*/
	public function Init() {
	
	}
	
	/**
  	* 	Make user a admin.
  	*
  	*	@param ID of user to be promoted.
  	*/
  	public function makeAdmin($id=null) {


		if($this->user->IsAdministrator()) { 		
	  		$groupsNr = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('get groups'));
  			$adminGrp = null;
  			foreach($groupsNr as $val) {
  				if($val['akronym'] == 'admin') {
  					$adminGrp=$val['id'];
	  			}
  			}
  		
  			if($adminGrp!=null && $id!=null) {
	  			try {
  					$this->db->ExecuteQuery(self::SQL('insert into user2group'), array($id, $adminGrp));
	  				$this->session->AddMessage('notice', 'User was promoted to admin.');
  				} catch(Exception $e) {
  					$this->session->AddMessage('notice', 'Failed to promote user.');
  				}
  			}
  		} else {
  			$this->session->AddMessage('warning', 'You cannot promote a user unless your an administrator.');
  		}
  		
  		Header('Location:'.$_SESSION['lastPage']);
  	}
  	
  	/**
  	*	Make user a writer.
  	*
  	*	@param ID of user to be promoted.
  	*/
  	public function makeWriter($id=null) {
  			
  		if($this->user->IsAdministrator()) { 		
	  		$groupsNr = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('get groups'));
  			$writerGrp = null;
  			foreach($groupsNr as $val) {
  				if($val['akronym'] == 'writer') {
  					$writerGrp=$val['id'];
	  			}
  			}
  			
  			if($writerGrp!=null && $id!=null) {
	  			try {
		  			$this->db->ExecuteQuery(self::SQL('insert into user2group'), array($id, $writerGrp));
  					$this->session->AddMessage('notice', 'User was promoted to writer');
  				} catch (Exception $e) {	
  					$this->session->AddMessage('notice', 'Failed to promote user.');
	  			}
	  		}
	  		
  		} else {
  			$this->session->AddMessage('warning', 'You cannot promote a user unless your an administrator.');
  		}
  		
  		Header('Location:'.$_SESSION['lastPage']);

  	}
  	
  	/**
  	*	Delete a user.
  	*
  	*	@param ID of user to be deleted.
  	*/
	public function Delete($id=null) {
		
		if($this->user->IsAdministrator()){
  			$this->db->ExecuteQuery(self::SQL('delete user'), array($id));	
  			Header('Location:'. $this->request->CreateUrl('acp'));
  		}
	}

	/**
	*	Login, check DB for user/pass
	*/
	public function Login($akronymOrEmail, $pass, $create=false) {
		
		$values = array(
			'akronym' => $akronymOrEmail,
			'name'	  => null,
			'email'	  => $akronymOrEmail,
			'password'=> $pass
		);
		
		$user = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('check user password'), array($akronymOrEmail, $akronymOrEmail));
		$user = (isset($user[0])) ? $user[0] : null;
		
		if(self::CheckPassword($pass, $user['salt'],$user['password']))
		{
			unset($user['password']);
			unset($user['salt']);
		
			if($user) {
				$user['groups'] = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('get group memberships'), array($user['id']));
				$this->session->SetAuthenticatedUser($user);
				if(!$create){
					$this->session->AddMessage('success', "Welcome '{$user['name']}'");
				}
			}
			
		} else {
		
			$this->session->AddMessage('warning', "Could not login, user does not exists or password did not match.");
			$user=null;
		}
		
		return ($user != null);
	}
	
	/**
	*	IsAuthenticated, check session if current user is authenticated
	*/
	public function IsAuthenticated() {
		return ($this->session->GetAuthenticatedUser() != false);
	}
	
	/**
	*	GetUserProfile, get all info about the user
	*/
	public function GetUserProfile() {
		return $this->session->GetAuthenticatedUser();
	}
	
	/**
	*	Logout, allow user to log out
	*/
	public function LogOut() {
		$this->session->UnsetAuthenticatedUser();
		$this->session->AddMessage('success', "You have been successfully logged out.");
	}
	
	/**
	*	GetAcronym, get users acronym
	*/
	public function GetAcronym() {
		$user = self::GetUserProfile();
		return $user['akronym'];
	}
	/**
	 * 	GetId, returns id of user
	 *
	 * @return userId
	 */
	public function GetId() {
		
		$user = self::GetUserProfile();
		return $user['id'];
	}
	
	/**
	*	GetGravatar, get users gravatar
	*/
	public function GetGravatar() {
		$user = self::GetUserProfile();
		return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($user['email']))) . '.jpg?s=40';
	}
	
	public function MakeGravatar($email) {
		return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '.jpg?s=40';
	}
	
	/**
	*	GravatarGenerator, get all users gravatars as array
	*/
	public function GravatarGenerator() {
		$user = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('get all'));
		
		$gravatar=array();
		
		foreach($user as $u) {
			$gravatar["{$u['akronym']}"]=array('acronym' => $u['akronym'], 'gravatar' => $this->MakeGravatar($u['email']));
		}
		
		return $gravatar;
	}
	
	/**
	* 	Get all users
	*/
	public function GetAllUsers() {
		
		$users=$this->db->ExecuteSelectQueryAndFetchAll(self::SQL('get all'));
		/*foreach($users as $key => $val) {
			$users["{$key}"]['groups'] = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('get group memberships'), array($val['id']));
		}*/
		
		$i=0;
		foreach($users as $key => $val) {
			$groups = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('get group memberships'), array($users[$i]['id']));
			$groupsAkronyms = array();
			foreach($groups as $grp) {
				array_push($groupsAkronyms, $grp['akronym']);
			}
		
			$users["{$key}"]['groups']=$groupsAkronyms;
			$i++;
		}
		
		return $users;
	}
	
	/**
	*	IsAdministrator, check if user is administrator
	*/
	public function IsAdministrator() {
		$user = self::GetUserProfile();
		$ifAdmin = false;
		
		if($this->IsAuthenticated()) {
			foreach($user['groups'] as $val) {
				if($val['akronym'] == 'admin')
					$ifAdmin=true;
			}
		}
			
		return $ifAdmin;
	}
	
	/**
	*	IsAdministrator, check if user is administrator
	*/
	public function IsWriter() {
		$user = self::GetUserProfile();
		$ifWriter = false;
		
		
		if($this->IsAuthenticated()) {
			foreach($user['groups'] as $val) {
				if($val['akronym'] == 'writer' || $val['akronym'] == 'admin')
					$ifWriter=true;
			}
		}
		
		return $ifWriter;
	}
	
	/**
    * Create password.
    *
    * $param $plain string the password plain text to use as base.
    */
  	public function CreatePassword($plain, $salt=true) {
    
    	if($salt) {
	      $salt = md5(microtime());
    	  $password = md5($salt . $plain);
	    } else {
    	  $salt = null;
	      $password = md5($plain);
    	}
	
		return array('salt'=>$salt, 'password'=>$password);
	}
	
	/**
   	* Check if password matches.
   	*
   	* @param $plain string the password plain text to use as base.
   	* @param $salt string the user salted string to use to hash the password.
   	* @param $password string the hashed user password that should match.
  	* @returns boolean true if match, else false.
   	*/
  	public function CheckPassword($plain, $salt, $password) {
    	if($salt) {
      		return $password === md5($salt . $plain);
    	} else {
    	  	return $password === md5($plain);
    	}
 	 }
	
	/**
   	* Save user profile to database and update user profile in session.
   	*
   	* @returns boolean true if success else false.
   	*/
	public function Save() {
//    	$this->db->ExecuteQuery(self::SQL('update profile'), array($this['name'], $this['email'], $this['id']));
 		$this->db->ExecuteQuery(self::SQL('update profile'), array($this['name'], $this['email'], $this['id']));
	    $this->session->SetAuthenticatedUser($this->profile);
    	return $this->db->RowCount() === 1;
  	}
  
  
    /**
    * Change user password.
    *
    * @param $password string the new password
   	* @returns boolean true if success else false.
   	*/
	public function ChangePassword($password) {
//	    $this->db->ExecuteQuery(self::SQL('update password'), array($password, $this['id']));
		$enpass = self::CreatePassword($password);
	    $this->db->ExecuteQUery(self::SQL('update password'), array($enpass['password'], $enpass['salt'],$this['id']));
    	return $this->db->RowCount() === 1;
  	}
  	
  	/**
   * Create new user.
   *
   * @param $acronym string the acronym.
   * @param $password string the password plain text to use as base. 
   * @param $name string the user full name.
   * @param $email string the user email.
   * @returns boolean true if user was created or else false and sets failure message in session.
   */
   
  public function Create($acronym, $password, $name, $email) {
    $pwd = $this->CreatePassword($password);
    $time = date('c');
    $this->db->ExecuteQuery(self::SQL('insert into user'), array($acronym, $name, $email, $pwd['password'], $pwd['salt'], $time));
    if($this->db->RowCount() == 0) {
      $this->AddMessage('error', "Failed to create user.");
      return false;
    }
    return true;
  }

}

?>