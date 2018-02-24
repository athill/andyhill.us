<?php
namespace App\Services;

use Log;
use Cache;
use Illuminate\Support\Facades\Storage;

class InspireService {

	const CACHE_KEY = 'inspire';
	const STORAGE_ROOT = 'data/inspire';

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
    	$files = Storage::allFiles(self::STORAGE_ROOT);
    	$data = [];
		foreach ($files as $path) {
			// $path = $file->getPath();
			$area = preg_replace("/.*\/([^\/]+)$/", "$1", dirname($path)); 
			// dd($area);
		    if (!isset($data[$area])) {
		    	$data[$area] = [];
		    }

		    $key = preg_replace("/(.*)\.txt/", "$1", basename($path));
		    $content = Storage::get($path);
		    list($title, $content) = explode("\nCONTENT\n", $content);
		    $sections = explode("\nCREDITS\n", $content);
		    list($content, $credits) = $sections;
		    $data[$area][] = [ 'key' => $key, 'content' => $content, 'credits' => $credits, 'title' => $title ];
		}
		return $data;
    }

    /**
     * Generates an inspire template file in data/n
     */
    public function makeInspire($category, $title, $content=null, $credits=null) {
    	$content = "$title\nCONTENT\n[content]\nCREDITS\n[credits]";
    	$slug = $this->sluggify($title);
    	$destination = self::STORAGE_ROOT."/${category}/${slug}.txt";
    	Storage::put($destination, $content);
    	return $this->log('info', "Added '${title}' to ${destination}");
    }

    private function sluggify($str)  {
    	return preg_replace("/[^a-z0-9]+/", '', strtolower($str));
    }

  	protected function log($type, $message) {
  		return [ 'type' => $type, 'message' => $message ];	
  	}

  	private function getCategories() {
  		$directory = storage_path(self::STORAGE_ROOT);
  		//// shoud be able to $categories = Storage::directories(storage_path(self::STORAGE_ROOT)); or something like that
  		return array_diff(scandir($directory), array('..', '.'));
  	}
}
