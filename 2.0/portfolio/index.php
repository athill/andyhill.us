<!--
<script type="text/javascript">
$(function() {
	$(".portfolio-entry").click
});
</script>
-->
<?php


class site {
		var $title;
		var $url;
		var $img;
		var $comment;
		
		function __construct($title, $url, $img, $comment="") {
			$this->title = $title;
			$this->url = $url;
			$this->img = $img;
			$this->comment  = $comment;
		}
		
		function render() {
				global $h;
				$h->odiv('class="portfolio-entry"');
				$h->oa($this->url, 'target="_blank"');
				$h->div($this->title, 'class="title"');
				$h->img('/portfolio/'.$this->img, '', 'class="img"');
				$h->div($this->url, 'class="url"');
				/*
				if ($thins->comment !== "") {
					$h->div($this->url, 'class="comment"');
				}
				*/								
				$h->ca();
				$h->cdiv();
		}
		
}

$sites = array(
/*
	new site("Market Square Communications", "http://marketsquarecommunications.com", "img/marksquarecommscreencap.png", 
		"Quick project from '09. Hope they're doing well."),
*/
	new site("Pizza King of Carmel", "http://pizzakingofcarmel.com", "img/pizzakingscreencap.png", 
		"Coming soon!"),

);

for ($i = 0; $i < count($sites); $i++) {
		$sites[$i]->render();
}
?>
