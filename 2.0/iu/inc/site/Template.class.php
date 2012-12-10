<?php
include_once($GLOBALS['incroot']."/html.class.php");
$h = html::singleton();

class Template {
	private $template;
	private $templateText = "default";
	private $home;
	public $menu;
	private $includes = array(
		//"/global/js/swfobject.js",
//		"/global/js/nav.js",
		//"/global/js/offspring.js",
		//"/global/js/spamspan.js",
		//"/global/js/breadcrumbs.js",
		//"/js/newdocwindow.js",
		//"/js/zebrarows.js",
		//"/js/load.js",
		//"/js/offsitelinks.js"	
	  );
	
	
	public function __construct($menu, $templateText="default") {
		global $incroot;
		$this->templateText = $templateText;
		include_once($GLOBALS['incroot']."/site/templates/".$this->templateText.".class.php");
		$this->template = new TemplateInstance($this) or die("???");
		$this->menu = $menu;
	}
	
	public function head() {
	  global $h, $pageTitle;
	  ////Add scripts/sheets from template
	  $scripts = explode(",", $this->template->scripts);
	  $sheets = explode(",", $this->template->stylesheets);
	  $this->includes = array_merge($this->includes, $scripts, $sheets);
	  ////Add scripts/styles from jsModules
	  include_once($GLOBALS['incroot']."/JsModule.class.php");
	  $jsMods = new JsModule();
	  foreach ($GLOBALS['jsModules'] as $module => $bool) {
		  if ($bool) {
			  	$mod = $jsMods->modules[$module];
		  		$this->includes = array_merge($this->includes, $mod['scripts'], $mod['styles']);
		  }
	  }
 	  ////Add scripts/sheets from $GLOBALS
	  $this->includes = array_merge($this->includes, $GLOBALS['scripts'], $GLOBALS['stylesheets']);
	  ////HTML/head
	  $h->ohtml($pageTitle, $this->includes);
	  if (array_key_exists('headerExtra', $GLOBALS)) {
		$h->tnl($GLOBALS['headerExtra']);  
	  }
	  $h->body($this->template->bodyAtts);		
	}
	
	
	////For accessibility
	public function skipNav() {
	  global $h;
	  $h->odiv('id="skip"');
	  $h->tag("p", '', "Skip to:", true);
	  $links = array(
	  	array("display" => "Content"),
		array("display" => "Search"),
		array("display" => "Primary Navigation"),
		array("display" => "Secondary Navigation"),
		array("display" => "Mini Index")
	  );
	  for ($i = 0; $i < count($links); $i++) $links[$i]['href'] = "#skip".($i+1);
	  $h->linkList($links);
	  $h->cdiv();		
	}
	////Website header
	public function heading() {
		$this->template->heading();	
	}
	
	////Left side bar
	public function leftSideBar() {
		global $h, $leftSideBar;
		$links = array();
		switch ($leftSideBar) {
			case "":
			case "none":
				break;
			case "about":
				$root = $this->menu->xml->xpath("//links[@display='About Us']");
				$links = array();
				$pre = $root[0]['href'];
				foreach ($root[0] as $node) {
					$atts = '';
					$href = (string)$pre.$node['href'];
					if (stripos($_SERVER['SCRIPT_NAME'], $href)) $atts = 'class="active"';
					$links[] = array('href' => $href, 'display' => $node['display'], 'liAtts' => $atts);
				}
				$h->linkList($links);
				break;	
			case "reports":
				$root = $this->menu->xml->xpath("//links[@display='Reports']");
				//print(count($root[0]->children()) . "<br />"););
				$links = $this->menu->xml2linkArray($root[0], "/reports/");
				//print_r($links);
				$tmp = array_pop($links);
				array_push($links, 
					array('href' => '/resources/IRDSI/', 'display' => 'Institutional Research Data Sources and Information'));
				array_push($links, $tmp);
				//print_r($links);
				$h->linkList($links);
				break;
			case "pnc":
				include_once("/ip/uirr/wwws/reports/census/inc/sidemenu.inc.php");
				break;
			default: 
				die("Bad sideNav type in Template.class.php");
		}
				
	}
	
	public function breadcrumbs() {
	  global $h;
	  //$h->script('KW_breadcrumbs("UIRR Home","&raquo;",0,1,"index.php",4,5)');		
	  $this->menu->displayPath();
	}
	
	public function footer() {
		$this->template->footer();	
	}
	
}
?>
