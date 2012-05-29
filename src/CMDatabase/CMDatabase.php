<?php
/**
*	Database - Dealing with your database! SQL etc
*/

class CMDatabase {

	/**
	*	Some memebers
	*/
	private $db = null;
	private $stmt = null;
	private static $numQueries = 0;
 	private static $queries = array();
 	
 	
 	/**
	*	Constructor, db info goes into the paramters.
	*/
 	public function __construct($dsn, $user = null, $pass = null, $driver_opt = null){
 	
		$this->db = new PDO($dsn, $user, $pass, $driver_opt);
      	$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); 	
 	
 	}
 	
 	/**
	*	Set atributes to DB
	*/
 	public function SetAttribute($attribute, $value){
 		
 		return $this->db->setAttribute($attribute, $value);
 	}
 	
 	/**
	*	Getters
	*/
	public function GetNumQueries() { return self::$numQueries; }
  	public function GetQueries() { return self::$queries; }
 	
 	/**
	*	Execute select-query with arguments and retrun resultset.
	*/
	public function ExecuteSelectQueryAndFetchAll($query, $params=array()){
    	
    	$this->stmt = $this->db->prepare($query);
	    self::$queries[] = $query; 
	    self::$numQueries++;
	    $this->stmt->execute($params);
	
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
 	/**
	*	Execute a SQL-query and ignore the resultset.
	*/
	public function ExecuteQuery($query, $params = array()) {
    	
    	$this->stmt = $this->db->prepare($query);
	    self::$queries[] = $query; 
	    self::$numQueries++;
	
		return $this->stmt->execute($params);
  	}
	
 	/**
	*	Constructor, db info goes into the paramters.
	*/
	public function LastInsertId() {
    	
    	return $this->db->lastInsertid();
	}
	
 	/**
	*	Constructor, db info goes into the paramters.
	*/
	public function RowCount() {
    	
    	return is_null($this->stmt) ? $this->stmt : $this->stmt->rowCount();
  	}
	
}

?>
