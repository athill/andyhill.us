<?php

$local['template'] = 'none';
require_once('../inc/application.php');
//// set category
$category = (array_key_exists('category', $_GET)) ? $_GET['category'] : 'Wires';

//// define feeds
$feeds = array(
	"Wires" => array(
		"http://feeds.reuters.com/reuters/politicsNews",
		"http://hosted.ap.org/lineups/POLITICSHEADS-rss_2.0.xml?SITE=NJMOR&SECTION=HOME",
	),

	"Left" => array(
		"http://www.huffingtonpost.com/feeds/verticals/politics/index.xml",
		"http://feeds.dailykos.com/dailykos/index.xml",
		"http://www.prospect.org/articles_rss.jsp",
		"http://feeds.feedburner.com/talking-points-memo",
		//"",

	),
	"Right" => array(
		"https://www.nationalreview.com/rss.xml",
		// "http://lucianne.com/rssfeed/",
		"http://feeds.feedburner.com/americanthinker",
		"http://ace.mu.nu/index.rdf",
		// "http://www.moonbattery.com/index.xml",
		'http://newsbusters.org/blog/feed',
		// http://feeds.feedburner.com/FoundryConservativePolicyNews
		
	),
	"Libertarian" => array(
		"http://feeds.feedburner.com/reason/AllArticles?format=xml",
		"http://feeds2.feedburner.com/CatoDispatch",
		"http://www.dailypaul.com/rss.xml",
		'http://libertarianstandard.com/feed/'
		//"http://www.lewrockwell.com/rss.xml",
		//"http://bytestyle.tv/rss.xml",
		
	),
	"TV" => array(
		"http://feeds.abcnews.com/abcnews/politicsheadlines",
		"http://feeds.cbsnews.com/CBSNewsMain",
		"http://rss.cnn.com/rss/cnn_topstories.rss",
		"http://www.foxnews.com/about/rss/feedburner/foxnews/politics",
		"http://www.msnbc.msn.com/id/3032552/device/rss/rss.xml",
	),
	"Print" => array(
		////http://www.nyjobsource.com/papers.html
		"http://rssfeeds.usatoday.com/usatoday-NewsTopStories",
		"http://feeds.wsjonline.com/wsj/xml/rss/3_7011.xml",
		"http://feeds.nytimes.com/nyt/rss/HomePage",
		"http://feeds.latimes.com/latimes/news/nationworld/nation",
		"http://feeds.washingtonpost.com/rss/politics",
	),
	"Radio" => array(
		"http://www.npr.org/rss/rss.php?id=1001",
		"http://www.democracynow.org/democracynow.rss",
		"http://feeds.feedburner.com/RushLimbaugh-AllContent",
		"http://www.marketplace.org/latest-stories/long-feed.xml",
	),
	"Congress" => array(
		"http://www.opencongress.org/bill/atom/most/viewed",
		"http://www.govtrack.us/users/events-rss2.xpd?monitors=misc:activebills",
		"http://feeds.technorati.com/politics/",
		"http://www.opensecrets.org/news/atom.xml",
		"http://www.rollcall.com/issues/index.xml",
	),
	"Indiana" => array(
		"http://www.indystar.com/apps/pbcs.dll/section?Category=NEWS05&template=rss&mime=XML",
		"http://www.opencongress.org/people/atom/402675_Daniel_Coats",
		"http://www.opencongress.org/people/atom/412205_Joe_Donnelly",
		"http://www.in.gov/portal/news_events/39832.xml",

	),
	"Bloomington" => array(
		"http://www.heraldtimesonline.com/rss/local.xml",
		"http://bloomington.in.gov/documentTypes/documents.php?format=rss;documentType_id=9",
		"http://www.opencongress.org/people/atom/412428_Todd_Young",
		'http://www.idsnews.com/news/feeds/rss.aspx'
	),
);
//// Build the structure and output
// require_once($site['incroot'].'/lastRSS.php');
// $rss = new lastRSS;
// $rss->cache_dir = './cache';
// $rss->cache_time = 3600; // one hour

// $rtn = array();
// foreach ($feeds[$category] as $i => $feed) {
// 	if ($rs = $rss->get($feed)) {
// 		$rtn[] = $rs;
// 	} else {
// 		$rtn[] = array('title'=>"Error", 'desription'=>'fubar');
// 	}
// }



require_once($site['incroot'].'/simplepie/autoloader.php');
$feed = new SimplePie();
$rtn = array();

foreach ($feeds[$category] as $f) {
	$feed->set_feed_url($f);
	$feed->init();
	$feed->handle_content_type();

	$tmp = array(
		'title'=>$feed->get_title(),
		'link'=>$feed->get_permalink(),
		'description'=>$feed->get_description(),
		'items'=>array()
	);
	foreach ($feed->get_items() as $item) {
		$tmp['items'][] = array(
		'title'=>$item->get_title(),
		'link'=>$item->get_permalink(),
		'description'=>$item->get_description(),
		'date'=>$item->get_date('j F Y | g:i a')
		);
	}
	$rtn[] = $tmp;
}

header('Content-Type: application/json');
echo(json_encode($rtn));
?>

