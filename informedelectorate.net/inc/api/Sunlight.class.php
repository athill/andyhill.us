<?php
require_once('Api.class.php');

class Sunlight extends Api {
	protected $url = 'http://api.realtimecongress.org/api/v1/';
	protected $key = '0f9d6efec2874d029e55c76f67f08a88';	

	public function get($collection, $method, $params=array()) {
		switch ($collection) {
			case 'congress':
				$this->url = 'http://services.sunlightlabs.com/api/';
				////http://services.sunlightlabs.com/api/api.method.format?apikey=YOUR_API_KEY&<params>
				break;
			case 'openstates':
				$this->url = 'http://openstates.org/api/v1/';
				$this->separator = '/';
				////http://openstates.org/api/v1/bills/?{SEARCH-PARAMS}&apikey={YOUR_API_KEY}
				break;
			case 'capitolwords':
				$this->url = 'http://capitolwords.org/api/';
				////http://capitolwords.org/api/dates.json?apikey=<YOUR_KEY>
				break;
			case 'transparencydata':
				$this->url = 'http://transparencydata.com/api/1.0/';
				////http://transparencydata.com/api/1.0/<method>.<format>
				break;
			case 'realtime':
			default:
				$this->url = 'http://api.realtimecongress.org/api/v1/';
				break;
		}
		return parent::get($method, $params);

	}

	function getFullName($d) {
		$name = $d['firstname'];
		if ($d['middlename'] != '') $name .= ' '.$d['middlename'];
		if ($d['nickname'] != '') $name .= ' ('.$d['nickname'].')';
		$name .= ' '.$d['lastname'];		
		return $name;
	}

}




//
//
//
//
?>