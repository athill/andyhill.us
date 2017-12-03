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
			$key = preg_replace("/.*\/([^\/]+)$/", "$1", $path);
			// dd($file); 
		    if (!isset($data[$key])) {
		    	$data[$key] = [];
		    }
		    $content = file_get_contents($file->getPathname());
		    $sections = explode("\nCREDITS\n", $content);
		    list($content, $credits) = $sections;
		    $data[$key][] = [ 'content' => $content, 'credits' => $credits ];
		}
		dd($data);
		return $data;
    }
}
