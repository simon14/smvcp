<?php
/**
* A model for content stored in database.
* 
* @package SmvcCore
*/
class CMContent extends CObject implements IHasSQL, ArrayAccess, IModule {


  /**
   * Implementing interface IModule. Manage install/update/deinstall and equal actions.
   */
  public function Manage($action=null) {
    switch($action) {
      case 'install': 
        try {
          $this->db->ExecuteQuery(self::SQL('drop table content'));
          $this->db->ExecuteQuery(self::SQL('create table content'));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Hello World!', '', 'blog', "This is a demo post.\n\nThis is another row in this demo post.", 1, '', '', 'plain', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Hello Word Again!', '', 'blog', "This is another demo post.\n\nThis is another row in this demo post.",  1, '', '', 'plain', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Hello World Once More!', '', 'blog', "This is one more demo post.\n\nThis is another row in this demo post.",  1, '', '', 'plain', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Home', '', 'page' , "This is a demo page, this could be your personal home-page.\n\nLydia is a PHP-based MVC-inspired Content management Framework, watch the making of Lydia at: http://dbwebb.se/lydia/tutorial.",  2, '', '', 'plain', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('About', '', 'page' , "This is a demo page, this could be your personal about-page.\n\nLydia is used as a tool to educate in MVC frameworks.",  2, '', '', 'plain', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Download', '', 'page', "This is a demo page, this could be your personal download-page.\n\nYou can download your own copy of lydia from https://github.com/mosbth/lydia.",  2, '', '', 'plain', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Page with BBCode', '', 'page', "This is a demo page with some BBCode-formatting.\n\n[b]Text in bold[/b] and [i]text in italic[/i] and [url=http://dbwebb.se]a link to dbwebb.se[/url]. You can also include images using bbcode, such as the lydia logo: [img]http://dbwebb.se/lydia/current/themes/core/logo_80x80.png[/img]",  3, '', '', 'bbcode', date('c')));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('Page with HTMLPurifier', '', 'page', "This is a demo page with some HTML code intended to run through <a href='http://htmlpurifier.org/'>HTMLPurify</a>. Edit the source and insert HTML code and see if it works.\n\n<b>Text in bold</b> and <i>text in italic</i> and <a href='http://dbwebb.se'>a link to dbwebb.se</a>. JavaScript, like this: <javascript>alert('hej');</javascript> should however be removed.",  3, '', '', 'htmlpurify', date('c')));
          return array('success', 'Successfully created the database tables and created a default "Hello World" blog post, owned by you.');
        } catch(Exception$e) {
          die("$e<br/>Failed to open database: " . $this->config['database'][0]['dsn']);
        }
      break;
      
      case 'cow':
      	break; 
      
      default:
        throw new Exception('Unsupported action for this module.');
      break;
    }
  }
  
  /**
   * Properties
   */
  public $data;


  /**
   * Constructor
   */
  public function __construct($id=null) {
    parent::__construct();
    if(!empty($id)) {
      $this->LoadById($id);
    } else {
      $this->data = array();
    }
  }


  /**
   * Implementing ArrayAccess for $this->data
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->data[] = $value; } else { $this->data[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->data[$offset]); }
  public function offsetUnset($offset) { unset($this->data[$offset]); }
  public function offsetGet($offset) { return isset($this->data[$offset]) ? $this->data[$offset] : null; }
	
  /**
   * Delete content. Adds a date when it was deleted in the database, does not remove the content entirly.
   */
  public function Delete($id=null) {
  	
  	if($this->user->IsAuthenticated() && $id!=null){
  		
  		
  		$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
  		$userIdCont = $res[0]['idUser'];
  		//$res2 = $this->user->GetUserProfile();
  		//$userId = $res2['id'];
  		$userId = $this->user->GetId();
  		
  		if($userId==$userIdCont || $this->user->IsAdministrator()) {
	  		if($id!=null) {
		  		$this->db->ExecuteQuery(self::SQL('delete content'), array(date('c'), $id));
  				$this->session->AddMessage('notice', 'Post deleted');
  			}
  		} else {
  			$this->session->AddMessage('error', 'You cannot delete another users post');
  		}
  	} else {
  		$this->session->AddMessage('error', 'You are not logged in');
  	}
  }
  
  /**
   * Restores content.
   */
  public function Restore() {
  	
  	if($this->user->IsAuthenticated() && $this->data['id']!=null){
  		
  		if($this->user->IsAdministrator()) {
  		
	  		$this->db->ExecuteQuery(self::SQL('restore content'), array($this->data['id']));
  			$this->session->AddMessage('notice', 'Post restored');
  		} else {
  			$this->session->AddMessage('error', 'You cannot restore a post unless your an administrator.');
  		}
  	}
  }
  
  public function Like() {
  	
  	if(empty($_SESSION['voted']["{$this->data['id']}"])) {
  		$this->db->ExecuteQuery(self::SQL('like'), array($this->data['id']));
	  	$_SESSION['voted']["{$this->data['id']}"]=true;
  	} else {
  		$this->session->AddMessage('error', 'Already liked this post');
  	}
  	
  }

  /**
   * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
   *
   * @param string $key the string that is the key of the wanted SQL-entry in the array.
   */
  public static function SQL($key=null) {
    $queries = array(
      'drop table content'		=> "truncate table Content; drop table Content",
      'create table content'	=> "CREATE TABLE `Content` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `title` varchar(40) DEFAULT NULL,  `short` varchar(150) DEFAULT NULL,  rating int(11) DEFAULT '0', `type` varchar(40) DEFAULT NULL,  `content` text,  `idUser` int(11) DEFAULT NULL,  `image` text,  `img` text,  `filter` varchar(10) DEFAULT NULL,  `created` datetime DEFAULT NULL,  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,  `deleted` datetime DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
      'insert content'          => "INSERT INTO `Content` (`title`, `short`, `type`, `content`, `idUser`, `image`, `img`, `filter`, `created`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);",
      'select * by id'          => 'SELECT c.*, u.akronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.id=?;',
      'select * by key'         => 'SELECT c.*, u.akronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.key=%s;',
      'select *'         		=> 'SELECT c.*, u.akronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id;',
      'select-all-desc'         => "SELECT c.*, u.akronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id ORDER BY c.id DESC;",
      'select-all-asc'          => "SELECT c.*, u.akronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id ORDER BY c.id ASC;",
      'update content'          => "UPDATE Content SET title=?, short=?, type=?, content=?, image=?, img=?, filter=? WHERE id=?;",
      'delete content'			=> "UPDATE Content SET deleted = ? WHERE id = ?;",
      'restore content'			=> "UPDATE Content SET deleted = NULL WHERE id = ?;",
      'like'					=> "UPDATE Content SET rating = rating+1 WHERE id = ?;",
      'select next news'		=> "select * from Content where id<? and type='news' order by id desc;",
      'select back news' 		=> "select * from Content where id>? and type='news' order by id asc;",
     );
    if(!isset($queries[$key])) {
      throw new Exception("No such SQL query, key '$key' was not found.");
    }
    return $queries[$key];
  }  

  /**
   * Go next new. Automaticlly get next 'news', created for the browsing buttons in page-view.
   *
   * @returns array with next new, else null.
   */
  public function GoNextNews() {
  	
  	$res=$this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select next news'), array($this['id']));
  	
  	$res = isset($res[0]) ? $res[0] : null;
  	
  	return $res;
  	
  } 
   
   
  /**
   * Go back new. Automaticlly get next 'news', created for the browsing buttons in page-view.
   *
   * @returns array with earlier new, else null.
   */
  public function GoBackNews() {
  
  	$res=$this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select back news'), array($this['id']));
  	
  	$res = isset($res[0]) ? $res[0] : null;
  	
  	return $res;
  }

  /**
   * Save content. If it has a id, use it to update current entry or else insert new entry.
   *
   * @returns boolean true if success else false.
   */
  public function Save($content=null) {
    $msg = null;
    if($this['id']) {
      //echo sprintf(self::SQL('update content'), $content['title'], $content['subtitle'], $content['type'], $content['content'], $content['image'], $content['video']);
      //echo $this['id'];
      $this->db->ExecuteQuery(self::SQL('update content'), array($content['title'], $content['short'], $content['type'], $content['content'], $content['image'], $content['img'], $content['filter'], $this['id']));
      $msg = 'update';
    } else {
      //echo sprintf(self::SQL('insert content'), $content['title'], $content['subtitle'], $content['type'], $content['content'], $this->user['id'], $content['image'], $content['video'], date('c'));
      $this->db->ExecuteQuery(self::SQL('insert content'), array($content['title'], $content['short'], $content['type'], $content['content'], $this->user['id'], $content['image'], $content['img'], $content['filter'], date('c')));
      $this['id'] = $this->db->LastInsertId();
      $msg = 'created';
    }
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->session->AddMessage('success', "Successfully {$msg} content '{$this['key']}'.");
    } else {
      $this->session->AddMessage('error', "Failed to {$msg} content '{$this['key']}'.");
    }
    return $rowcount === 1;
  }
  
  public static function Filter($data, $filter)  {
  	switch($filter) {
      case 'html': $data = nl2br($data); break;
      case 'bbcode': $data = nl2br(bbcode2html(htmlentities($data))); break;
      case 'htmlpurify': $data = nl2br(CHTMLPurifier::Purify($data)); break;
      case 'plain': 
      default: $data = nl2br(makeClickable(htmlentities($data))); break;
    }
    return $data;
  } 
  
  public function GetFilteredData() {
  	return $this->Filter($this['content'], $this['filter']);
  } 
  
  public function FilterContent() {
	$this['content'] = $this->Filter($this['content'], $this['filter']);
  }
  
  
  /*============================
  //	Get filtered data for all posts in DB, used primary for blog
  //===========================*/
  public function GetAllFilteredData($order=null) {
 	
 	$res=null;
 	
 	
 	if($order='desc'){
	
	 	try{
		  	$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select-all-desc'));
	  	} catch(exception $e) {
  			$res = null;
	  	}
  	}
  	else if($order='asc'){
  	
  		try{
  	 		$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select-all-asc'));
  		} catch(exception $e) {
  			$res = null;
  		}
  	}
  	else{
  	
  		try{
  	 		$res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select *'));
  		} catch(exception $e) {
  			$res = null;
  		}
  	}
  	
  	for($i=0;$i<count($res);$i++){
  		$res[$i]['content']=$this->Filter($res[$i]['content'], $res[$i]['filter']);
  	}
  	
  	
  	return $res;
  }

  /**
   * Load content by id.
   *
   * @param id integer the id of the content.
   * @returns boolean true if success else false.
   */
  public function LoadById($id) {
    $res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
    if(empty($res)) {
      $this->session->AddMessage('error', "Failed to load content with id '$id'.");
      return false;
    } else {
      $this->data = $res[0];
    }
    return true;
  }
  
  
  /**
   * List all content.
   *
   * @returns array with listing or null if empty.
   */
  public function ListAll() {
    
    try {
      return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select *'));
    } catch(Exception$e) {
      return null;
    }
  }
  
  
  
}