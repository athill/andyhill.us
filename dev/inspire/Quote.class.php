<?php
include_once($GLOBALS['incroot']."/html.class.php");	
$h = html::singleton();

class Quote {
	function __construct($file) {		
		$this->lines = file($file);
//		print_r($this->lines);
	}

	function render() {
		global $h;
		$credits = false;
		$h->odiv('id="quote"');
		$h->odiv('id="quote-content"');
		foreach ($this->lines as $line) {
			$line = trim($line);
			if ($line == "CREDITS") {
				$h->cdiv();
				$h->odiv('id="quote-credits"');
				continue;
			}
			$h->tbr($line);
		}
		$h->cdiv();
		$h->cdiv();
	}
} 
?>
