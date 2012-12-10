<?php

class ADS {
	////Directory Service
	private $ds;
	private $server = "ads.iu.edu";
	private $root;
	private $user = "ads\sesads";
	private $pass = "Let me view My AD users!";
	public $recordCount = 0;
	
	function __construct() {
		$this->root = "dc=".implode(",dc=", explode(".", $this->server));
		$this->ds = ldap_connect($this->server);
		if (!$this->ds) die("can't connect to server");
		$success = ldap_bind($this->ds, $this->user, $this->pass);
		if (!$success) die("Can't bind to ADS");
	}
	
	public function query($attributes, $start, $filter="objectclass=*") {
		$sr = ldap_search($this->ds, $start, $filter, explode(",", $attributes));
		$this->recordCount = ldap_count_entries($this->ds, $sr);
		$info = ldap_get_entries($this->ds, $sr);
		return $info;
	}
	////Returns basic info for a user.
	public function getUserData($user) {
		$meta = array(
			"email" 	=> 	"mail",
			"username" 	=> 	"cn",
			"name" 		=> 	"displayname",
			"phone" 	=> 	"telephonenumber",
			"office" 	=> 	"department",
			"campus" 	=> 	"description",
			"room" 		=> 	"physicaldeliveryofficename",
			"building" 	=> 	"physicaldeliveryofficename",
			"fname" 	=>	"givenname",
			"lname" 	=> 	"sn"
		);
		$attributes = implode(",", array_unique(array_values($meta)));
		$result = $this->query($attributes, "ou=accounts,".$this->root, "cn=$user");
		////No result: fill assoc array with empty values
		if ($this->recordCount == 0) {
			foreach ($meta as $key => $val) {
				$meta[$key] = "";	
			}
		////Success
		} else {
			////Fill assoc array with results
			foreach ($meta as $key => $val) {
				$meta[$key] = $result[0][$val][0];	
			}
			////Tweak some values
			$n = explode(", ", $meta['name']);
			if (count($n) > 0) $meta['name'] = $n[1] . " " . $n[0];
			$o = explode(" ", $meta['room']);
			$meta['building'] = $o[0];
			$meta['room'] = (count($o) > 0) ? $o[1] : "";
		}
		return $meta;
	}
	
	
	public function usersGroups($username) {
		$result = $this->query("memberof", "cn=$username,ou=accounts,".$this->root);
		$groups = array();
		for ($i = 0; $i < count($result[0]['memberof']); $i++) {
			$r = explode(",", $result[0]['memberof'][$i]); 
			$groups[] = preg_replace("/cn=/i", "", $r[0]);	
		}
		return $groups;
	}
	
	public function getDnForGroup($groupname) {
		echo $this->root .  " samaccountname=$groupname";
		//$result = $this->query("dn", $this->root, "samaccountname=$groupname");
		$result = $this->query("dn", "ou=accounts,".$this->root, "(samaccountname=$groupname)");
		return $result;	
	}
}

?>