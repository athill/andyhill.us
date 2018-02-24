<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cache;

use App\Services\InspireService;

class InspireController extends Controller 
{
	private $data;

    public function index() 
    {
    	$cachekey = InspireService::CACHE_KEY;
    	if (! Cache::has($cachekey)) 
    	{
    		$service = new InspireService;
    		$service->update();
    	}
    	return Cache::get($cachekey);
    	//// get data directly
    	// $service = new InspireService;
    	// return $service->getData();
    }
}
