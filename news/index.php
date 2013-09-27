<?php
$local['scripts'] = array('news.js');
$local['stylesheets'] = array('news.css');
$local['jsModules']['underscore'] = true;
require_once("../inc/application.php");

require_once($site['incroot'].'/lastRSS.php');




$h->h1('um');
?>
<script type="text/template" class="template">

<h2><%- rc.listTitle %></h2>

<ul>
<% _.each( rc.listItems, function( listItem ){ %>
	<li>
	<%- listItem.name %>
	<% if ( listItem.hasOlympicGold ){ %>
		<em>*</em>
	<% } %>
	</li>
<% }); %>
</ul>


<% var showFootnote = _.any(_.pluck( rc.listItems, "hasOlympicGold" )); %>


<% if ( showFootnote ){ %>
	<p style="font-size: 12px ;">
	<em>* Olympic gold medalist</em>
	</p>
<% } %>

</script>
<!-- END: Underscore Template Definition. -->
 
 
<!-- Include and run scripts. -->
<?php
 $h->script('// When rending an underscore template, we want top-level
// variables to be referenced as part of an object. For
// technical reasons (scope-chain search), this speeds up
// rendering; however, more importantly, this also allows our
// templates to look / feel more like our server-side
// templates that use the rc (Request Context / Colletion) in
// order to render their markup.
_.templateSettings.variable = "rc";
 
// Grab the HTML out of our template tag and pre-compile it.
var template = _.template(
	$( "script.template" ).html()
);
 
// Define our render data (to be put into the "rc" variable).
var templateData = {
	listTitle: "Olympic Volleyball Players",
	listItems: [
		{
			name: "Misty May-Treanor",
			hasOlympicGold: true
		},
		{
			name: "Kerri Walsh Jennings",
			hasOlympicGold: true
		},
		{
			name: "Jennifer Kessy",
			hasOlympicGold: false
		},
		{
			name: "April Ross",
			hasOlympicGold: false
		}
	]
};
 
// Render the underscore template and inject it after the H1
// in our current DOM.
$( "h1" ).after(
template( templateData )
);');


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


