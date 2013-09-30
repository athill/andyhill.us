<?php
$local['scripts'] = array('news.js');
$local['stylesheets'] = array('news.css');
$local['jsModules']['underscore'] = true;
$local['jsModules']['ui'] = true;
require_once("../inc/application.php");
?>

 
 
<!-- Include and run scripts. -->
<?php
//// playing with block functions
// $h->otag('script', 'type="text/template"');
// $h->tblock('_.each(thing1, thing2)', function() {
// 	global $h;
// 	//$h->h1($h->rtn('tint', array('test'));

// });
// $h->ctag('script');




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

//// Navigation
$options = explode(',', "Wires,Left,Right,Libertarian,TV,Print,Radio,Congress,Indiana,Bloomington");
$items = array(
	'display' => array(),
	'atts' => array()
);
foreach ($options as $option) {
	$items['display'][] = $option;
	$items['atts'][] = 'class="feed-category" id="feed-category-'.$option.'" data-category="'.$option.'"';
}
$h->liArray('ul', $items['display'], 'id="news-nav"', $items['atts']);

////feeds
$h->tnl('<output id="rss-feeds"></output>');
?>
<script type="text/template" id="feeds">
<% _.each(rc, function(feed, i) { %>
	<article class="feed">
		<header class="feed-header">
			<h3 class="feed-title elipsis" title="<%- feed.title %>"><%- feed.title %></h3>
			<div class="feed-actions">
				<a href="<%- feed.link%>" title="site" target="_blank">site</a>
				<a href="#" class="feed-toggleall" title="expand all" id="feed-expandall_<%= i %>">expand all</a>
			</div>
		</header>
		<ul>
		<% _.each(feed.items, function(item, j) { %>
			<% if (j > 9) return item; %>
			<li class="elipsis">
			<a href="<%- item.link %>" class="feed-links feed-links<%= i %>" id="feed-link<%= i %>_<%= j %>"
				title="" target="_blank"><%- item.title.replace(/<!\[CDATA\[/g, '').replace(/\]\]>/g, '') %></a>
			<div class="feed-descriptions feed-descriptions_<%= i %>" id="feed-description<%= i %>_<%= j %>">
				<%= item.description.replace(/&lt;/g, '<').replace(/&gt;/g, '>') %>
			</div>
			</li>
		<% }); %>
		</ul>
	</article>
<% }); %>
</script>
<?php



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
