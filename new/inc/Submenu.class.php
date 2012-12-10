<?php
class Submenu {
	/***
	 * $items	array  list of items of form href|display
	 ********************/
	private $test = ""; 
	private $showExtra = 0;
	private $extra = "";
	 
	function __construct($config, $id="submenu") {
		global $h, $filename;
		$items = $config['tabs'];
		if (array_key_exists('test', $config)) {
			$this->test = $config['test'];
		}
		// added by Maitrey
//--------------------------------------------------------		
		if (array_key_exists('width', $config)){
			$divWidth = ' style = "width:'.$config['width'].'"';
			//echo $divWidth;
		}
		else $divWidth = '';
		if (array_key_exists('extra', $config))
				$this->extra = $config['extra'];
		//print_r($items);
//-------------------------------------------------------
		$links = array();
		
		for ($i = 0; $i < count($items); $i++) {
			$link = $items[$i];
			$children = array();
			if (strpos($link, "*") > -1) {
				list($link, $chs) = explode(":", $link);
				$chs = explode(",", $chs);
				for ($j = 0; $j < count($chs); $j++) {
					$children[] = $this->parseItem($chs[$j]);	
				}
			}
			$item = $this->parseItem($link);
			if (count($children) > 0) $item['children'] = $children;

			$links[] = $item;	
		}
		//$h->startBuffer();
		//$h->select("year1", range(2000, date("Y")), '2011', 'class = "cdsYearOptionSelect1"');
		//$links[] = $h->endBuffer();
		$h->odiv('id="'.$id.'" class="submenu"'.$divWidth);
		//print_r($links);
		//added by Maitrey
//----------------------------------------------------------------------------------------------
		if($this->extra != "")
		{
			$h->odiv('class = "submenu-wrapper"');
			$h->linkList($links, $divWidth); //, 'class="sf-menu"'
			$h->cdiv();
			$h->tnl($this->extra);
			/*
			
			
			$h->odiv('class = "cdsYearOption"');
			$h->label("yearMenu", 'Select a different year:', 'class = "cdsYearOptionLabel"');
			$year= (array_key_exists('year', $_GET)) ? $_GET['year'] : date("Y");
			$h->select("yearMenu", range(2000, date("Y")), $year, 'class = "cdsYearOptionSelect"');
			$h->cdiv();
			*/
		}
//----------------------------------------------------------------------------------------------
		else $h->linkList($links, $divWidth); //, 'class="sf-menu"'
		$h->cdiv();
		//$h->div('', 'style="clear: both;"');
		//$h->br();
	}
	
	function parseItem($link) {
		global $filename;
		$item = array();
		if (strpos($link, "|") > -1) {
			list($item['href'], $item['display']) = explode("|", $link);	
		} else {
			$item['href'] = $link;	
			$item['display'] = $link;	
		}
		if ($this->test != "" && $this->test->test($item)) { 
			$item['liAtts'] = 'class="active"';	
		} else if ($item['href'] == $filename || $item['href'] == './?'.$_SERVER['QUERY_STRING']) {
			$item['liAtts'] = 'class="active"';	
		}
		return $item;		
	}

}

?>