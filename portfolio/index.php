<?php
require_once("../inc/setup.inc.php");
$page = new Page(array(
	'stylesheets'=>array('portfolio.css')
));

$text=<<<EOT
For better or worse, all the cool stuff I do for IU is behind authentication, 
so this site itself is part of my portfolio, attempting to demonstrate the capabilities 
and flexibilty of the infrastructure as well as tackling specific challenges, 
such as displaying an image gallery, in a pleasing way.
EOT;

$h->p($text);

class Site {
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
				$h->odiv(['class' => 'link']);
				$h->a($this->url, $display, 'target="_blank"');
				$h->cdiv();
				$h->div($this->comment, 'class="comment"');
				$h->cdiv();
		}
		
}

$sites = array(
	new Site("Pizza King of Carmel", "http://pizzakingofcarmel.com", "img/pizzakingscreencap.png", 
		'I created and maintain the Pizza King site for my cousin, Jeff. It\'s a good 
place and he\'s a good guy, you should 
<a href="http://pizzakingofcarmel.com/directions.php" target="_blank">check it out.</a>'),
	new Site("What's in my Freezer?", "https://wimf.space", "img/wimf-screenshot.png", 
		'An inventory management tool. <a href="https://github.com/athill/wimf" target="_blank">Github</a>'),

	new Site("jquery-readmore", "https://github.com/athill/jquery-readmore", "img/jquery-readmore.png", 
		'jQuery plugin read more functionality<br /><a href="/jquery-readmore/demo.html" target="_blank">Demo</a>'),		
	new Site("InformedElectorate.net", "http://InformedElectorate.net", "img/informedelectorate.png", 
		'Skeleton of site idea that would encourage civic engagement.'),		
	new Site("From URL to Web Page", "From URL to Web Page.zip", "img/url2web.png", 
		"Presentation I did for work"),
	new Site("Metaprogramming in ColdFusion", "cfmeta/", "img/cfmeta.png", 
		'Presentation I did for cfmeetup. <br /><a href="cfmeta/slideshow.pdf" target="_blank">PDF</a>
		 ... <a href="https://github.com/athill/cfmeta/" target="_blank">GitHub</a>'),	
);

foreach ($sites as $site2) {
		$site2->render();
}

$page->end();
?>
