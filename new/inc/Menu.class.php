<?php
/**
 * XML menu interface
 *
 * 
 *
 * @package includes
 * @author andy hill 1 2009
 * @version 1.0
 *
 */

include_once($GLOBALS['incroot']."/html.class.php");

	
$h = html::singleton();

class Menu {
	 	
 	/**
	 * Simple Xml Object
	 *
	 */  
 	public $xml;
 	
 	
 	/**
	 * constructor
	 *
	 * create an instance of the Menu class
	 * pass in the persistence type(i.e. database, file, standard out)
	 * have a factory create the persistence object that log events are sent to
	 *
	 * @param string
	 */ 
 	function __construct($pathToXmlFile) {
		if(!$this->xml=simplexml_load_file($pathToXmlFile)) {
		    trigger_error('Error reading XML file',E_USER_ERROR);
		}

		//print_r($this->xml);		
 	}	
////TODO fix so works in intranet
	public function topNav() {
		global $h, $webroot;
		$links = array();
//		print("in here");
//		print_r($this->xml);
		foreach ($this->xml as $elem) {
			$display = (string)$elem['display'];
			$href = (string)$elem['href'];
			$atts = '';
			if (stripos($_SERVER['SCRIPT_NAME'], $href) > 0) {
				$atts = 'class="active"';
			}
			if (preg_match("/\[intranet\]/", $href)) {
				$href=preg_replace("/\[intranet\]/", "https://".$_SERVER['HTTP_HOST'].$webroot, $href);
				
			} else {
				$href = "http://".$_SERVER['HTTP_HOST'] . $webroot . $href;
			}
			

			$links[] = array("href" => $href, "display" => $display, "liAtts" => $atts);
		}
		$h->linkList($links);
	}
	

	function buildPathAndSetTitle($xml, $path="", $depth=0, $nodes=array()) {
		global $h;
//		print_r($xml);
		foreach ($xml as $elem) {
//			print("<br />");
//			print_r($GLOBALS['script']);
			$node = preg_replace("/\//", "", $elem['href']);
//			$h->tbr($node . " " . $GLOBALS['script'][$depth]);
			if ($node == $GLOBALS['script'][$depth]) {		
				$path .= $elem['href'];
				if (!preg_match("/^http/", $path)) {
					if (array_key_exists('secure', $elem)) {
						$path = "https://".$_SERVER['HTTP_HOST'].$path;	
					} else {
						$path = "http://".$_SERVER['HTTP_HOST'].$path;	
					}
				}
				$type = (string) $elem->getName();
				if ($depth + 1 == count($GLOBALS['script'])) {
					$nodes[] = (string) $elem['display'];
					if (!isset($GLOBALS['pageTitle'])) $GLOBALS['pageTitle'] = (string) $elem['display'];
					return $nodes;
				} else {
					$h->startBuffer();			
					$h->a($path, $elem['display'], '');	
					$nodes[] = $h->endBuffer();
					if (!isset($GLOBALS['pageTitle'])) $GLOBALS['pageTitle'] = $elem['display'];
					return $this->buildPathAndSetTitle($elem, $path, ++$depth, $nodes);
				}
				
			} else if ($depth + 1 == count($GLOBALS['script'])) {
				return $nodes;	
			}
			
		}
	}



	
	
	public function xml2linkArray($root, $pre="") {
		$links = array();
		$i = -1;
		foreach ($root->children()as $node) {
			$i++;
			//print_r($node);
			//print($node['display'] . "<br />");
			
			$link = array('href'=>$pre.$node['href'], 'display' => $node['display']);
			$links[$i] = $link;
			if (count($node->children()) > 0) {
//				$links[$i]['children'] = array();
				$links[$i]['children'] = $this->xml2linkArray($node, $pre.$node['href']);
			}
		}
		return $links;
		
	}

	/*
	public function xml2linkArray($root, $links = array(), $depth=0, $pre="") {
		//print_r($root);
		for ($i = 0; $i < count($root->children()); $i++) {
			$node =$root[$i]; 
			//print_r($node);
			print($node['display'] . "<br />");
			
			$link = array('href'=>$pre.$node['href'], 'display' => $node['display']);
			$links[$i] = $link;
			if (count($node->children()) > 0) {
				$links[$i]['children'] = array();
				return $this->xml2linkArray($node, $links[$i]['children'], $depth++, $pre.$node['href']);
			}
		}
		return $links;
		
	}
	*/
	
	function displayPath() {
		echo "here2";
		global $h, $breadcrumbs;
		for ($i = 0; $i < count($breadcrumbs); $i++) {
			$h->op($breadcrumbs[$i]);
			if ($i < count($breadcrumbs) - 1) $h->op(" &raquo; ");
		}
	}

	function displayMenu() {
		global $h;
		global $view;
		echo "here";
		if ($GLOBALS['menuStyle'] == "popup") {
			$h->odiv('id="dhtmlgoodies_menu"');
			$h->local("${view}&menuStyle=tree", "Tree Menu");
			$h->oul();
		} else {
			$h->odiv();
			$h->local("${view}&menuStyle=popup", "Popup Menu");
			$h->oul('class="mktree"');
		}
		$this->generateMenu($this->xml);
		$h->cul();
		$h->cdiv();
	}

	function generateMenu($xml, $path="", $depth=0) {
		global $h;
		foreach ($xml as $elem) {
			$h->startBuffer();
			if ($elem['redirect']) $h->a($elem['redirect'], $elem['display']);
			else $h->local($path.$elem['href'], $elem['display']);
			$link = trim($h->endBuffer());
			$type = $elem->getName();
			////Recur if appropriate (limit popup style depth)
			if ($type == "links" && 
					($GLOBALS['menuStyle'] == "tree" 
					|| $depth < 1 )
					&& count($elem->children()) > 0) {
				$h->oli();
				$h->tnl($link);
				$depth++;
				$h->oul();
				$this->generateMenu($elem, $path.$elem['href'], $depth);
				$depth--;
				$h->cul();
				$h->cli();
			} else {	
				$h->li($link);
			}
		}
	}
}
?>
