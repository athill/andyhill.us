<?php
class OracleConnect {
	private $connection;
	public $recordCount = 0;
	public $fields = array();
	
	public function __construct($user, $pass, $connectionString) {
		$this->connection = oci_connect($user, $pass, $connectionString);
		$this->throwExceptionOnError($this->connection); 
	}
	
	public function query($sql) {
		$stmt = oci_parse($this->connection, $sql);
		oci_execute($stmt);
		$this->recordCount = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);
		//print_r(error_get_last());
		$ncols = oci_num_fields($stmt);
		$this->fields = array();
		for ($i = 1; $i <= $ncols; $i++) {
			$this->fields[]  = oci_field_name($stmt, $i);
		}
		/*
		$rows = array();
		while ($row = oci_fetch_object($stmt)) {
			$rows[] = $row;
	   }
	   */
	   oci_free_statement($stmt);
	   return $rows;	
	}
	
	public function safequery($sql, $mappings=array()) {
		$stmt = oci_parse($this->connection, $sql);
		foreach ($mappings as $key => $val) {
			oci_bind_by_name($stid, $key, $mappings[$key]);
		}
		oci_execute($stid);
		$this->recordCount = oci_fetch_all($stmt, $rows, null, null, OCI_FETCHSTATEMENT_BY_ROW);
		$ncols = oci_num_fields($stmt);
		$this->fields = array();
		for ($i = 1; $i <= $ncols; $i++) {
			$this->fields[]  = oci_field_name($stmt, $i);
		}
		oci_free_statement($stmt);
		return $rows;	
	}
	
	public function close() {
		oci_close($this->connection);
	}
	
  private function throwExceptionOnError($link = null) { 
    if($link == null) { 
      $link = $this->connection; 
    } 
    if(oci_error($link)) { 
      $msg = oci_errno($link) . ": " . oci_error($link); 
      throw new Exception('Oracle Error - '. $msg); 
    }         
  } 	
	
}
?>
