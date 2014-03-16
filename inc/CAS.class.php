<?php
class CAS {
	private $username = "";
	private $MM_UserAuthorization = "";
	private $CAS_Server = "https://cas.iu.edu/cas/";
	private $debug = false;

	function __construct() {
		$ticket = "";
		$casurl = $this->CAS_Server . "login?cassvc=IU&casurl=http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
		////See if already authenticated, 
		//if ($debug) print_r($_SESSION);
		$this->checkUsernameAndAuth();
		//if ($debug) print_r($_SESSION);;
		////Not authenticated
		if ($this->username == "") {
			//$this->debugger("Username is blank");
			////See if ticket is in URL
			if (array_key_exists("casticket", $_GET)) $ticket = $_GET['casticket'];
			////Ticket not in URL, authenticate
			if ($ticket == "") {
				//$this->debugger("Empty Ticket");
				////Store URL & Form info
				$this->setTempVars();
				////redirect to cas
				//WriteOutput(Variables.casurl);
				//if ($this->debug) print_r($_SESSION);
//				Request.utils.abort();
				//if (debug) REquest.utils.fwrite(ExpandPath("sessionid.txt"), SerializeJSON(Session));
				//$this->debugger($casurl);
				
				header("Location: ".$casurl);
				
			////Back from CAS, validate ticket and get userid
			} else {
				$this->debugger("Getting username");
				$httpurl = $this->CAS_Server . "validate?cassvc=IU&casticket=" . $_GET['casticket'] . 
					"&" . "casurl=http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
				$this->debugger($httpurl);				
				$data = file($httpurl);
				if ($this->debug) print_r($data);
				if (trim($data[0]) == "yes") {
					////username should be 2nd element in cas_auth_info array
					$_SESSION['user'] = trim($data[1]);
					////Reinstate temp vars
					$this->debugger("reinstating temp vars");
					if (array_key_exists("temp_form", $_SESSION)) $_POST = array_merge($_POST, json_decode($_SESSION['temp_form'], true));
					if (array_key_exists("temp_url", $_SESSION)) {
						$this->debugger("has url");	
						if ($this->debug) print_r($_SESSION);
						$_GET = array_merge($_GET, json_decode($_SESSION['temp_url'], true));
						if ($this->debug) print_r($_GET);
					}
					////Clear temp vars
					$this->clearTempVars();
				
				////Any other response means CAS validation failed.  Do whatever is needed 
				////to handle the failure.  Keep in mind that url.returnpage should have the 
				////URL that we should go back to.
				} else {
					$this->debugger("Bad Ticket - reauthenticate");
					////Store URL & Form info
					$this->setTempVars();
					////redirect to cas
					//header("Location: " .$casurl);
				}
			}
			//$_SESSION['CASusername'] = $NetID;
			//$_SESSION['user'] = $NetID;
		} else {
			$this->debugger("username is set?");
			if (!array_key_exists("user", $_SESSION)) {
				//$_SESSION['user'] = $_SESSION['CASusername'];	
			}
		}
	}
	
	function debugger($str) {
		if ($this->debug) {
			print("<strong>Debugging: </strong>" . $str . "<br />");	
		}
	}
	
	function checkUsernameAndAuth() {
		$this->username = "";
		if (array_key_exists("casUsername", $_SESSION)) $this->username = $_SESSION['casUsername'];
	}
	
	function setTempVars() {
			$_SESSION['temp_path'] = $_SERVER['SCRIPT_NAME'];
				$_SESSION['temp_form'] = json_encode($_POST);
				$_SESSION['temp_url'] = json_encode($_GET);
	}
	
	function clearTempVars() {
			$_SESSION['temp_path'] = $_SERVER['SCRIPT_NAME'];
			$_SESSION['temp_form'] = array();
			$_SESSION['temp_url'] = array();			
	}
}        
?>