<?php
namespace App\Services;

use Cache;
use Feeds;
use Log;

class NewsService {

	const CACHE_PREFIX = 'news:';

	public $feeds = [
	"Wires" => [
		"http://feeds.reuters.com/reuters/politicsNews",
		"http://hosted2.ap.org/atom/APDEFAULT/89ae8247abe8493fae24405546e9a1aa",
	],

	"Left" => [
		"http://www.huffingtonpost.com/feeds/verticals/politics/index.xml",
		'https://www.dailykos.com/blogs/main.rss',
		"http://www.prospect.org/articles_rss.jsp",
		"http://feeds.feedburner.com/talking-points-memo",

	],
	"Right" => [
		"https://www.nationalreview.com/rss.xml",
		"http://feeds.feedburner.com/americanthinker",
		"http://ace.mu.nu/index.rdf",
		'http://newsbusters.org/blog/feed',
		
	],
	"Libertarian" => [
		"http://feeds.feedburner.com/reason/AllArticles?format=xml",
		"http://feeds2.feedburner.com/CatoDispatch"
		
	],
	'Government'=>[
		'https://www.federalregister.gov/blog/feed',
		'http://gao.gov/rss/reports_450.xml',
		'http://www.cbo.gov/publications/all/rss.xml',
		'http://www.treasury.gov/rss/Pages/RSS.aspx?config=TreasuryNotes',
	],
	"TV" => [
		"http://feeds.abcnews.com/abcnews/politicsheadlines",
		"http://feeds.cbsnews.com/CBSNewsMain",
		"http://rss.cnn.com/rss/cnn_topstories.rss",
		"http://www.foxnews.com/about/rss/feedburner/foxnews/politics",
		"http://www.msnbc.msn.com/id/3032552/device/rss/rss.xml",
	],
	"Print" => [
		"http://rssfeeds.usatoday.com/usatoday-NewsTopStories",
		'http://www.wsj.com/xml/rss/3_7041.xml',
		"http://feeds.nytimes.com/nyt/rss/HomePage",
		"http://feeds.latimes.com/latimes/news/nationworld/nation",
		"http://feeds.washingtonpost.com/rss/politics",
	],
	"Radio" => [
		"http://www.npr.org/rss/rss.php?id=1001",
		"http://www.democracynow.org/democracynow.rss",
		'https://www.rushlimbaugh.com/rss/transcripts/25/1',
		"http://www.marketplace.org/latest-stories/long-feed.xml",
	],
	"Congress" => [
		"http://www.govtrack.us/users/events-rss2.xpd?monitors=misc:activebills",
		'https://www.congress.gov/rss/most-viewed-bills.xml',
		'https://www.congress.gov/rss/house-floor-today.xml',
		'https://www.congress.gov/rss/senate-floor-today.xml',
	],
	// "Indiana" => [
	// 	"http://www.indystar.com/apps/pbcs.dll/section?Category=NEWS05&template=rss&mime=XML",
	// 	"http://www.opencongress.org/people/atom/402675_Daniel_Coats",
	// 	"http://www.opencongress.org/people/atom/412205_Joe_Donnelly",
	// 	"http://www.in.gov/portal/news_events/39832.xml",
	// ],
	// "Bloomington" => [
	// 	"http://www.heraldtimesonline.com/rss/local.xml",
	// 	"http://bloomington.in.gov/documentTypes/documents.php?format=rss;documentType_id=9",
	// 	"http://www.opencongress.org/people/atom/412428_Todd_Young",
	// 	'http://www.idsnews.com/news/feeds/rss.aspx'
	// ],
];

	public function __construct() {

	}

	/**
	 * Updates the cache for all feeds
	 * @param $category string [null] category of feeds to update, updates all feeds if category is null
	 */
	public function update($category=null) {
		if (!is_null($category)) {
	    	if (!isset($this->feeds[$category])) {
	    		return ['type' => 'error', 'message' => 'Invalid Category '.$category];
	    	}		
	    	$this->updateCategory($category);
	    	Log::info('Updated news feed '.$category);
	    	return ['type' => 'info', 'message' => 'Updated news '.$category];
		} else {
			foreach ($this->feeds as $key => $value) {
				$this->updateCategory($key);
				Log::info('Updated news feed '.$key);
			}
		}
		return ['type' => 'info', 'message' =>  'Updated news'];

	}

	/**
	 * Updates and caches results for feed category
	 */
	public function updateCategory($category) {
    	$data = $this->getCategory($category);
    	$this->cache($category, $data);		
	}

	public function cache($category, $data) {
		Cache::forget(self::CACHE_PREFIX.$category);
		Cache::forever(self::CACHE_PREFIX.$category, $data);		
	}

    public function getCategory($category) {
    	if (!isset($this->feeds[$category])) {
    		return ['error' => 'Invalid Category'];
    	}
    	$rtn = [];
    	foreach ($this->feeds[$category] as $uri) {
    		$feed = Feeds::make($uri, true);
    		if ($feed->error()) {
    			// throw new \Exception($feed->error());
    			$rtn[] = ['error' => 'Error getting feed.'];
    			Log::warning('News: Unable to fetch '. $uri .'. '. $feed->error);
    		} else {
				$tmp = [
					'title'=>$feed->get_title(),
					'link'=>$feed->get_permalink(),
					'description'=>$feed->get_description(),
					'items'=>[]
				];
				foreach ($feed->get_items() as $item) {
					$tmp['items'][] = [
						'title'=>$item->get_title(),
						'link'=>$item->get_permalink(),
						'description'=>$item->get_description(),
						'date'=>$item->get_date('j F Y | g:i a')
					];
				}
				$rtn[] = $tmp;
			}
    	}
    	return $rtn;
    }	
}
