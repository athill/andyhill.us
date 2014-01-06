<?php
require_once("../inc/setup.inc.php");
$page = new Page(array(
	'stylesheets'=>array('portfolio.css')
));

$text=<<<EOT
<p>
For better or worse, all the cool stuff I do for IU is behind authentication, 
so this site itself is part of my portfolio, attempting to demonstrate the capabilities 
and flexibilty of the infrastructure as well as tackling specific challenges, 
such as displaying an image gallery, in a pleasing way.
</p>


EOT;

$h->p($text);

class site2 {
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
				$h->startBuffer();			
				$h->div($this->title, 'class="title"');
				$h->img('/portfolio/'.$this->img, '', 'class="img"');
				$h->div($this->url, 'class="url"');
				$display = $h->endBuffer();			
				$h->a($this->url, $display, 'target="_blank"');
				$h->div($this->comment, 'class="comment"');
				$h->cdiv();
		}
		
}

$sites = array(
/*
	new site("Market Square Communications", "http://marketsquarecommunications.com", "img/marksquarecommscreencap.png", 
		"Quick project from '09. Hope they're doing well."),
*/
	new site2("Pizza King of Carmel", "http://pizzakingofcarmel.com", "img/pizzakingscreencap.png", 
		'I created and maintain the Pizza King site for my cousin, Jeff. It\'s a good 
place and he\'s a good guy, you should 
<a href="http://pizzakingofcarmel.com/directions.php" target="_blank">check it out.</a>'),
	new site2("From URL to Web Page", "From URL to Web Page.zip", "img/url2web.png", 
		"Presentation I did for work"),
	new site2("Metaprogramming in ColdFusion", "cfmeta/", "img/cfmeta.png", 
		'Presentation I did for cfmeetup. <br /><a href="cfmeta/slideshow.pdf" target="_blank">PDF</a>
		 ... <a href="https://github.com/athill/cfmeta/" target="_blank">GitHub</a>'),	

);

foreach ($sites as $site2) {
		$site2->render();
}

$page->end();
?>
