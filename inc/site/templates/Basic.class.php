<?php
$h = html::singleton();
//echo "included";

class TemplateInstance {


	public $bodyAtts = 'id="default" class="default"';	
	public $stylesheets = array('/css/accessible.css');
	public $scripts = array('/js/jquery-1.10.1.min.js');
	private $base;
	
	public function __construct($base) {
		global $site;
		$this->base = $base;	
		$this->base->hasSkipNav = false;
		$GLOBALS['jsModules']['popup'] = false;
		$this->scripts[] = ($site['isPRD']) ? 
			'/js/jquery-migrate-1.2.1.min.js' : 
			'/js/jquery-migrate-1.2.1.js';		
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
