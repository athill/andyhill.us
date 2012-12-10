<?php
//connect to db
////drupal pass: Nokxy3hRWtbP
////wp password: x4Fi94zGFNMB

class DB {
	private $connection;
	private $result;

	private $dbs = array(
		////wordpress
		"wordpress" => array("user"=>"andyhil_wrdp1", "pass"=>"x4Fi94zGFNMB", "db"=>"andyhil_wrdp1"),
		////drupal
		"drupal" => array("user"=>"andyhil_drpl1", "pass"=>"Nokxy3hRWtbP", "db"=>"andyhil_drpl1")
	);


	

	function __construct($name) {
		if (!array_key_exists($name, $this->dbs)) {
			die("Unknown name in DB");
		}		
		$params = $this->dbs[$name];
		$this->connection=mysql_connect ("localhost", $params['user'], $params['pass']) 
			or die ('I cannot connect to the database because: ' . mysql_error());
		mysql_select_db ($params['db']) or die("Couldn't select db"); 		
	}

	public function query($sql) {
		$numParams = func_num_args();
		$params = func_get_args();

		if ($numParams > 1) {
			for ($i = 1; $i < $numParams; $i++){
			    $params[$i] = mysql_real_escape_string($params[$i]);
			}
			$sql = call_user_func_array('sprintf', $params);
		}

		$this->result = mysql_query($sql, $this->connection);
		if (!$this->result) die("No result: ".mysql_error());
		$ret = array();
		while ($row = mysql_fetch_assoc($this->result)) {
			$ret[] = $row;
		}
		mysql_free_result($this->result);
		return $ret;
	} 

	function insert($table, $args) {
		$keys = array_keys($args);
		$sql = "INSERT INTO $table(";
		for ($i = 0; $i < count($keys); $i++) {
			if ($i > 0) $sql .= ", ";
			$sql .= $keys[$i];
		}
		$sql .= ") VALUES (";
		$vals = array();
		for ($i = 0; $i < count($keys); $i++) {
			if ($i > 0) $sql .= ", ";
			$key = $keys[$i];
			$sql .= $this->check_input($args[$key]);
		}
		$sql .= ")";
		print $sql . "<br /><br />";
		mysql_query($sql, $this->connection) or die("insert failed ". mysql_error());
		return mysql_insert_id();
	}

	function update($table, $args, $where) {
		$sql = "UPDATE $table SET ";
		$keys = array_keys($args);
		for ($i = 0; $i < count($keys); $i++) {
			$key = $keys[$i];
			if ($i > 0) $sql .= ", \n";
			$sql .= $keys[$i]."=". $this->check_input($args[$key]);
		}
		$sql .= " WHERE " . $where;
		print $sql . "<br /><br />";
		mysql_query($sql, $this->connection) or die("Update failed ". mysql_error());

	}

	function check_input($value) {
		// Stripslashes
		if (get_magic_quotes_gpc()) {
		  $value = stripslashes($value);
		}
		// Quote if not a number
		if (!is_numeric($value)) {
		  $value = "'" . mysql_real_escape_string($value, $this->connection) . "'";
		}
		return $value;
	}


}



/*
$database = "andyhil_main";
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ($database) or die("Couldn't select db"); 
*/
?>
