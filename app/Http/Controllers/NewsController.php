<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cache;
use Feeds;

use App\Services\NewsService;

class NewsController extends Controller {


    public function index() {
    	return $this->show('Wires');
    }

    public function show($category) {
		$cachekey = NewsService::CACHE_PREFIX.$category;
		if (!Cache::has($cachekey)) {
			return ['error' => 'Invalid category '.$category];
		}
		return Cache::get($cachekey);
		// get in real time
		// $service = new NewsService;
		// return $service->getCategory($category);
    }
}
