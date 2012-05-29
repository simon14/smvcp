<?php

class CSQLManager {

	private $db;

	public function __construct() {
		$this->ConnectDB();
	}
	
	public function ConnectDB() {
		global $cs;
		
		$this->db = mysql_pconnect(
			$cs->config['database']['url'], 
			$cs->config['database']['user'], 
			$cs->config['database']['pass']
		);
		
		mysql_select_db('db_zapp', $this->db);
	}
	
	public function SendQuery($query) {
		
		mysql_query($query);
		
	}
	
}

?>