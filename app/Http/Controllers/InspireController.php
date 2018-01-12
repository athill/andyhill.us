<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cache;
use File;
use Log;

class InspireController extends Controller {
	private $data;

    public function index() {
    	$this->data =  Cache::remember('inspire', 60, function () {
    		return $this->getData();
    	});
        return $this->data;
    }

    private function getData() : array {
    	$files = File::allFiles(storage_path('data/inspire'));
    	// dd($files);
    	$data = [];
		foreach ($files as $file) {
			Log::info($file->getPath());
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
