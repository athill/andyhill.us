<?php
////jquery magic
$h->scriptfile($webroot."/news/rss.js");
////options tabs
$options = "Wires,Left,Right,Libertarian,TV,Print,Radio,Congress,Indiana,Bloomington";
$options = split(",", $options);
$h->otable();
for ($i = 0; $i < count($options); $i++) {
	$h->td($options[$i], 'class="rss-category" id="rss-category-'.$options[$i].'"');
}
$h->ctable();
$h->div("Wires", 'id="select-category" style="display: none;"');

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

?>


