<?php
$h = html::singleton();
//echo "included";

class TemplateInstance {


	public $bodyAtts = 'id="default" class="default"';	
	public $stylesheets = array('/css/accessible.css');
	public $scripts = array();
	private $base;
	
	public function __construct($base) {
		$this->base = $base;	
		$this->base->hasSkipNav = false;
		$GLOBALS['jsModules']['popup'] = false;
	}
	
	public function heading() {
	  global $h, $pageTitle;
	}

	
	public function footer() {
		global $h;
		$h->chtml();
	}
}

?>
