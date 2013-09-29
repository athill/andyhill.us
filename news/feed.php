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
		"http://lucianne.com/rssfeed/",
		"http://feeds.feedburner.com/americanthinker",
		"http://www.nationalreview.com/index.xml",
		"http://www.moonbattery.com/index.xml",
		
	),
	"Libertarian" => array(
		"http://www.dailypaul.com/rss.xml",
		"http://www.lewrockwell.com/rss.xml",
		"http://bytestyle.tv/rss.xml",
		"http://feeds2.feedburner.com/CatoDispatch",
	),
	"TV" => array(
		"http://feeds.feedburner.com/AbcNews_Politics",
		"http://feeds.cbsnews.com/CBSNewsMain",
		"http://rss.cnn.com/rss/cnn_topstories.rss",
		"http://www.foxnews.com/xmlfeed/rss/0,4313,0,00.rss",
		"http://www.msnbc.msn.com/id/3032552/device/rss/rss.xml",
	),
	"Print" => array(
		////http://www.nyjobsource.com/papers.html
		"http://rssfeeds.usatoday.com/usatoday-NewsTopStories",
		"http://feeds.wsjonline.com/wsj/xml/rss/3_7011.xml",
		"http://feeds.nytimes.com/nyt/rss/HomePage",
		"http://feeds.latimes.com/latimes/news/nationworld/nation",
		"http://feeds.washingtonpost.com/wp-dyn/rss/politics/index_xml",
	),
	"Radio" => array(
		"http://www.npr.org/rss/rss.php?id=1001",
		"http://www.democracynow.org/democracynow.rss",
		"http://www.prisonplanet.com/feed.rss",
		"http://feeds.feedburner.com/GlennBeckArticles",
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
		"http://www.opencongress.org/person/atom/300070_richard_lugar",
		"http://www.opencongress.org/person/atom/300006_evan_bayh",
		"http://www.in.gov/portal/news_events/39832.xml",

	),
	"Bloomington" => array(
		"http://www.heraldtimesonline.com/rss/local.xml",
		"http://bloomington.in.gov/documentTypes/documents.php?format=rss;documentType_id=9",
		"http://www.opencongress.org/person/atom/400177_baron_hill",
	),
);
//// Build the structure and output
require_once($site['incroot'].'/lastRSS.php');
$rss = new lastRSS;
$rss->cache_dir = './cache';
$rss->cache_time = 3600; // one hour

$rtn = array();
foreach ($feeds[$category] as $i => $feed) {
	if ($rs = $rss->get($feed)) {
		$rtn[] = $rs;
	}
}
header('Content-Type: application/json');
echo(json_encode($rtn));
?>

