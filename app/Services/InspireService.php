<?php
namespace App\Services;

use Log;
use File;
use Cache;

class InspireService {

	const CACHE_KEY = 'inspire';


	public function update() {
		try {
			$data = $this->getData();
			$this->cache($data);
			return [ 'type' => 'info', 'message' => 'Updated inspire' ];
		} catch (\Exception $e) {
			Log::error($e);
			return [ 'type' => 'error', 'message' => 'Something went wrong' ];
		}
	}

	public function cache($data) {
		Cache::forget(self::CACHE_KEY);
		Cache::forever(self::CACHE_KEY, $data);		
	}

    public function getData() : array {
    	$files = File::allFiles(storage_path('data/inspire'));
    	// dd($files);
    	$data = [];
		foreach ($files as $file) {
			$path = $file->getPath();
			$area = preg_replace("/.*\/([^\/]+)$/", "$1", $path); 
		    if (!isset($data[$area])) {
		    	$data[$area] = [];
		    }
		    $key = preg_replace("/(.*)\.txt/", "$1", $file->getBasename());
		    $content = file_get_contents($file->getPathname());
		    list($title, $content) = explode("\nCONTENT\n", $content);
		    $sections = explode("\nCREDITS\n", $content);
		    list($content, $credits) = $sections;
		    $data[$area][] = [ 'key' => $key, 'content' => $content, 'credits' => $credits, 'title' => $title ];
		}
		return $data;
    }
}
