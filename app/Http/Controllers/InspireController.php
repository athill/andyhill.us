<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cache;
use File;
use Log;

use App\Services\InspireService;

class InspireController extends Controller {
	private $data;

    public function index() {
    	$cachekey = InspireService::CACHE_KEY;
    	return Cache::get($cachekey);
    	//// get data directly
    	// $service = new InspireService;
    	// return $service->getData();
    }


}
