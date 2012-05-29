<?php
/**
*	comment model, talk to the database etc
*/
class CMComment extends CObject implements IHasSQL, IModule {

  /**
   * Implementing interface IModule. Manage install/update/deinstall and equal actions.
   */
  public function Manage($action=null) {
    switch($action) {
      case 'install': 
        try {
          $this->db->ExecuteQuery(self::SQL('drop table comment'));
          $this->db->ExecuteQuery(self::SQL('create table comment'));
          return array('success', 'Successfully created the database tables (or left them untouched if they already existed).');
        } catch(Exception$e) {
          die("$e<br/>Failed to open database: " . $this->config['database'][0]['dsn']);
        }
      break;
   	  
      default:
        throw new Exception('Unsupported action for this module.');
      break;
    }
  }
  
  /**
  *	Constructor
  */
  public function __construct($id=null) {
    parent::__construct();
    $this->id=$id;
  }

  /**
   *  SQL-handler from SQL Interface (IHasSQL)
   */
  public static function SQL($key=null, $values=null) {
  
  	$queries = array(
  		'drop table comment' 		=> 'DROP TABLE comment',
  		'create table comment'		=> "CREATE TABLE `comment` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `entry` text,  postId int, userId int, `date` datetime DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
  		'insert into comment' 		=> "INSERT INTO comment (entry, postId, userId, date) VALUES (?, ?, ?, ?);",
  		'select * from comment' 	=> 'SELECT * FROM comment ORDER BY id DESC;',
  		'delete from comment'		=> 'TRUNCATE TABLE comment;',
  	);
  	
  	if(!isset($queries[$key])) {
  		throw new Exception("No such SQL query, key '$key' was not found.");
  	}
  	
  	return $queries[$key];
  
  }
  
  /**
   *  Add a entry to the comment.
   */
  public function Add($entry=null, $userId=null){
  
  		$time = date('c');
  		$this->db->ExecuteQuery(self::SQL('insert into comment'), array($entry, $this->id, $userId, date('c')));
  		$this->session->AddMessage('info', 'Message added!');
  }
  
  /**
   *  Clear all entries from database.
   */
  public function Clear() {
  
  	  $this->db->ExecuteQuery(self::SQL('delete from comment'));
  	  $this->session->AddMessage('info', 'All messages removed!');
  }
  
  /**
   *  Read all entries from database.
   */
  public function ReadAll() {
    
    return  $this->db->ExecuteSelectQueryAndFetchAll("SELECT * FROM comment WHERE postId={$this->id} ORDER BY id DESC;");
  }
  
}

?>