<?php

class ebook extends MySQLDB {
	
	function __construct() {
		//global $session;
		$this->_db = new MySQLDB();
		//$this->model = new Model();
		//$q = "select value from co_config where name='applications'";
		//$result = mysql_query($q, $this->_db->connection);
		//$row = mysql_result($result,0);
		//$this->applications = json_decode($row);
	}
	
	function getAllPublishedEbooks() {
		
	}
	
	function getUserEbooks($id) {
		$ebooks = "";
		$q = "SELECT * FROM ebooks WHERE uid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$ebooks[$key] = $val;
				}
			
		}
		return $ebooks;
	}


}

$ebook = new ebook();
?>