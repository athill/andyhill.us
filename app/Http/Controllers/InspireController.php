<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use File;

class InspireController extends Controller {
	private $data;

    public function index() {
    	$this->data = $this->getData();
        return $this->data;
    }

    private function getData() : array {
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
