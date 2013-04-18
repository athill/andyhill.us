<?php
class Api {
	protected $url = '';
	protected $key = '';
	public $separator = '.json';

	function init($url='', $key='') {
		if ($url != '') $this->url = $url;
		if ($key != '') $this->key = $key;
	}

	protected function getUrl($method, $params=array()) {
		$url = $this->url.$method.$this->separator.'?apikey='.$this->key;
		// echo $url;
		foreach ($params as $k => $v) {
			if (!is_array($v)) {
				$url .= '&'.urlencode($k).'='.urlencode($v);
			} else {
				foreach ($v as $value) {
					$url .= '&'.urlencode($k).'='.urlencode($value);
				}
				//$url .= '&all_legislators=1';
			}
		}
		 // echo $url;
		return $url;
	}

	public function get($method, $params=array()) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getUrl($method, $params));
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$content = curl_exec($ch);
		return json_decode($content, true);
	}

}
?>