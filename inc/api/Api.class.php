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
		$url = $this->getUrl($method, $params);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$content = curl_exec($ch);
		// $url = $this->getUrl($method, $params);
		echo $url;
		echo $content;
		// $content = file_get_contents($url);
		return json_decode($content, true);
	}

}
?>
