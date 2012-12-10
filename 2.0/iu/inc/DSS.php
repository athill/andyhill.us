<?php
include_once("OracleConnect.php");

class DSS extends OracleConnect {
	private $user = "iuietrac";
	private $pass = "s354171006";
	private $connectionString = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=iedss.uits.indiana.edu) (PORT=1521)) (CONNECT_DATA=(SERVER=DEDICATED) (SERVICE_NAME = dss1prd.uits.indiana.edu)))";
	
	public function __construct() {
		return parent::__construct($this->user, $this->pass, $this->connectionString);	
	}
}
?>