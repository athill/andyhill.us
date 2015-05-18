<?php
require_once("../inc/setup.inc.php");
$page = new Page(array(
	'scripts'=>array('news.js'),
	'stylesheets'=>array('news.css'),
	'jsModules'=>array('underscore'=>true, 'ui'=>true)
));

//// geekout
$h->startBuffer();
$h->p("This page uses AJAX to retrieve its content. When a tab is clicked, the feeds 
change without reloading the entire page. Instead, a request is made to the 
server and a container is filled with the HTML returned by the server.");

$h->p('On the server side, each category is associated with a list of 
<a href="http://en.wikipedia.org/wiki/RSS" target="_blank">RSS feeds</a>. 
When a request comes in the RSS feeds for the selected category are retrieved and 
parsed to generate the HTML that is returned to the browser.');
$h->p('This is my first foray into hash ("#") navigation. This means when a tab is clicked on, 
JavaScript modifies the URL in the address bar to indicate the category, for example 
appending #Radio to the URL. Doing this both enables browser history and also allows 
users to directly load a category by adding the hash-category in the address bar 
themselves.');
$geekout = $h->endBuffer();

$page->template->template->geekout($geekout);

//// Navigation
$options = ['Wires','Government','Left','Right','Libertarian','TV','Print','Radio','Congress','Indiana','Bloomington'];
$items = [
	'display' => [],
	'atts' => []
];
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
			<li>
			<a href="<%- item.link %>" class="feed-links feed-links<%= i %> elipsis" id="feed-link<%= i %>_<%= j %>"
				title="" target="_blank"><%- item.title %></a>
			<div class="feed-descriptions feed-descriptions_<%= i %>" id="feed-description<%= i %>_<%= j %>">
				<%= item.description %>
				<br><br>
				Posted: <time><%= item.date %></time>
			</div>
			</li>
		<% }); %>
		</ul>
	</article>
<% }); %>
</script>
<?php
////  resources
$resources = [
	[
		'title'=>'Polls',
		'links'=>[
			["http://www.rasmussenreports.com/public_content/politics", "Rasmussen"],
			["http://www.gallup.com/poll/politics.aspx?CSTS=pollnav&to=POLL-Politics-News", "Gallup"]
		]
	],
	[
		'title'=>'Watchers',
		'links'=>[
			["http://opencongress.org", "opencongress.org"],
			["http://govtrack.us", "govtrack.us"],
			["http://opensecrets.org", "opensecrets.org"]
		]
	],
	[
		'title'=>'Government',
		'links'=>[
			["http://www.gpoaccess.gov/", "gpoaccess.gov"]
		]
	]
];

$h->odiv('id="resources"');
foreach ($resources as $resource) {
	$h->odiv('class="resource"');
	$h->h4($resource['title']);
	$links = [];
	foreach ($resource['links'] as $link) {
		$links[] = ['href'=>$link[0], 'display'=>$link[1]];
	}
	$h->linkList($links);
	$h->cdiv('/.resource');
}
$h->cdiv('/#resources');

$page->end();
?>
