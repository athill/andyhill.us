<?php
include_once("/ip/uirr/inc/html.class.php");
	
$h = html::singleton();


class footer {
	function display($column3="") {
		global $h;
		$h->cdiv();	////close content
		$h->cdiv(); ////close column2
		$h->odiv('id="column3"');
		if ($column3 != "") {
			$h->odiv('class="boxwrap"');
			$column3 = explode(",", $column3);
			for ($i = 0; $i < count($column3); $i++) {
				$h->odiv('class="box"');
				include($column3[$i]);	
				$h->cdiv();
			}
			$h->cdiv();
		}
		$h->cdiv();
		
		$h->cdiv(); ////close container
		$h->cdiv();	////close wrapper
		$h->odiv('id="footer"');
		$h->hr();
		$h->otag("p");
		$h->startBuffer();
		$h->img("/global/img/footer/blockiu.gif", "Block IU", 'width="22" height="28"');
		$h->a("http://www.iu.edu/", trim($h->endBuffer()), 'title="Indiana University" id="blockiu"');
		$h->tnl(" ");
		$h->a("http://www.iu.edu/comments/copyright.shtml", "Copyright");
		$h->tnl(" &copy; ".date("Y")." The Trustees of ");
		$h->a("http://www.iu.edu/", "Indiana University");
		$h->tnl("  &#124; ");
		$h->a("http://www.iu.edu/comments/complaint.shtml", "Copyright Complaints");
		$h->ctag("p");
		$links = array(
			array('href' => "/site/", 'display' => "Site Index"),
			array('href' => "/about/contact/", 'display' => "Contact Us"),
			array('href' => "/find/", 'display' => "Find People")
		);
		$h->linkList($links);
		$h->cdiv();
		$h->chtml();
	}
	
}
?>
