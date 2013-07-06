<?php
$local['scripts'] = array('news.js');
$local['stylesheets'] = array('news.css');
//$local['jsModules']['ui'] = true;
require_once("../inc/application.php");

$geekout=<<<EOT
<p>
This page uses AJAX to retrieve its content. When a tab is clicked, the feeds 
change without reloading the entire page. Instead, a request is made to the 
server and a container is filled with the HTML returned by the server. 
</p>
<p>
On the server side, each category is associated with a list of 
<a href="http://en.wikipedia.org/wiki/RSS" target="_blank">RSS feeds</a>. 
When a request comes in the RSS feeds for the selected category are retrieved and 
parsed to generate the HTML that is returned to the browser. 
</p>
<p>
This is my first foray into hash ("#") navigation. This means when a tab is clicked on, 
JavaScript modifies the URL in the address bar to indicate the category, for example 
appending #Radio to the URL. Doing this both enables browser history and also allows 
users to directly load a category by adding the hash-category in the address bar 
themselves.
</p>
EOT;

$template->template->geekout($geekout);


$options = "Wires,Left,Right,Libertarian,TV,Print,Radio,Congress,Indiana,Bloomington";
$options = explode(",", $options);
$items = array(
	'display' => array(),
	'atts' => array()
);


foreach ($options as $option) {
	$items['display'][] = $option;
	$items['atts'][] = 'class="rss-category" id="rss-category-'.$option.'"';
}
$h->liArray('ul', $items['display'], 'id="news-nav"', $items['atts']);

////feeds
$h->div("", 'id="rss-feed-container"');

////other links
$h->br(3);
$h->div("<strong>Other Resources</strong>", 'style="font-size: 16px;"');
$h->tnl("<strong>Polls:</strong>");
$h->a("http://www.rasmussenreports.com/public_content/politics", "Rasmussen");
$h->tnl(" ");
$h->a("http://www.gallup.com/poll/politics.aspx?CSTS=pollnav&to=POLL-Politics-News", "Gallup");
$h->br();
$h->tnl("<strong>Govenment:</strong>");
$h->a("http://opencongress.org", "opencongress.org");
$h->tnl(" ");
$h->a("http://govtrack.us", "govtrack.us");
$h->tnl(" ");
$h->a("http://opensecrets.org", "opensecrets.org");
$h->tnl(" ");
$h->a("http://www.gpoaccess.gov/", "gpoaccess.gov");

$template->footer();

?>


