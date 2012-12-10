<?php
$local['template'] = 'none';
require_once('../inc/application.php');

require_once('RSS.class.php');

//$category = (array_key_exists('category', $_GET)) ? $_GET['category'] : 'Wires';

$feeds = array();
switch ($category) {
	case "Wires":
		$feeds[] = "http://feeds.reuters.com/reuters/politicsNews";
		$feeds[] = "http://hosted.ap.org/lineups/POLITICSHEADS-rss_2.0.xml?SITE=NJMOR&SECTION=HOME";
		break;

	case "Left":
		$feeds[] = "http://www.huffingtonpost.com/feeds/verticals/politics/index.xml";
		$feeds[] = "http://feeds.dailykos.com/dailykos/index.xml";
		$feeds[] = "http://www.prospect.org/articles_rss.jsp";
		$feeds[] = "http://feeds.feedburner.com/talking-points-memo";
		//$feeds[] = "";

		break;
	case "Right":
		$feeds[] = "http://lucianne.com/rssfeed/";
		$feeds[] = "http://feeds.feedburner.com/americanthinker";
		$feeds[] = "http://www.nationalreview.com/index.xml";
		$feeds[] = "http://www.moonbattery.com/index.xml";
		
		break;
	case "Libertarian":
		$feeds[] = "http://www.dailypaul.com/rss.xml";
		$feeds[] = "http://www.lewrockwell.com/rss.xml";
		$feeds[] = "http://bytestyle.tv/rss.xml";
		$feeds[] = "http://feeds2.feedburner.com/CatoDispatch";
		break;
	case "TV":
		$feeds[] = "http://feeds.feedburner.com/AbcNews_Politics";
		$feeds[] = "http://feeds.cbsnews.com/CBSNewsMain";
		$feeds[] = "http://rss.cnn.com/rss/cnn_topstories.rss";
		$feeds[] = "http://www.foxnews.com/xmlfeed/rss/0,4313,0,00.rss";
		$feeds[] = "http://www.msnbc.msn.com/id/3032552/device/rss/rss.xml";
		break;

	case "Print":
		////http://www.nyjobsource.com/papers.html
		$feeds[] = "http://rssfeeds.usatoday.com/usatoday-NewsTopStories";
		$feeds[] = "http://feeds.wsjonline.com/wsj/xml/rss/3_7011.xml";
		$feeds[] = "http://feeds.nytimes.com/nyt/rss/HomePage";
		$feeds[] = "http://feeds.latimes.com/latimes/news/nationworld/nation";
		$feeds[] = "http://feeds.washingtonpost.com/wp-dyn/rss/politics/index_xml";
		break;
	case "Radio":
		$feeds[] = "http://www.npr.org/rss/rss.php?id=1001";
		$feeds[] = "http://www.democracynow.org/democracynow.rss";
		$feeds[] = "http://www.prisonplanet.com/feed.rss";
		$feeds[] = "http://feeds.feedburner.com/GlennBeckArticles";
		break;
	case "Congress":
		$feeds[] = "http://www.opencongress.org/bill/atom/most/viewed";
		$feeds[] = "http://www.govtrack.us/users/events-rss2.xpd?monitors=misc:activebills";
		$feeds[] = "http://feeds.technorati.com/politics/";
		$feeds[] = "http://www.opensecrets.org/news/atom.xml";
		$feeds[] = "http://www.rollcall.com/issues/index.xml";
		break;
	case "Indiana":
		$feeds[] = "http://www.indystar.com/apps/pbcs.dll/section?Category=NEWS05&template=rss&mime=XML";
		$feeds[] = "http://www.opencongress.org/person/atom/300070_richard_lugar";
		$feeds[] = "http://www.opencongress.org/person/atom/300006_evan_bayh";
		$feeds[] = "http://www.in.gov/portal/news_events/39832.xml";

		break;
	case "Bloomington":
		$feeds[] = "http://www.heraldtimesonline.com/rss/local.xml";
		$feeds[] = "http://bloomington.in.gov/documentTypes/documents.php?format=rss;documentType_id=9";
		$feeds[] = "http://www.opencongress.org/person/atom/400177_baron_hill";

		break;
}

//$h->otable('id="rss-feeds" cellspacing="8"');
$h->otag("ul", 'id="rss-feeds"');
foreach ($feeds as $i => $feed) {
	$h->otag("li");
	$rss = new rss($feed, $i);
	//echo 'here';
	$rss->display();
	$h->ctag("li");
//	if ($i %  2 == 1 && $i < (count($feeds) - 1)) $h->cotr();
}
//$h->ctable();
$h->ctag("ul");
/*

$h->otable('id="rss-feeds" cellspacing="8"');
foreach ($feeds as $i => $feed) {
	$h->otd();
	$rss = new rss($feed, $i);
	//echo 'here';
	$rss->display();
	$h->ctd();
	if ($i %  2 == 1 && $i < (count($feeds) - 1)) $h->cotr();
}
$h->ctable();
*/
//$h->script("initLinks();");
?>

