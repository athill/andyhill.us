<?php
namespace App\Services;

use Cache;
use Log;

class RecipesService {

	const CACHE_KEY = 'recipes';
	public $url = 'https://www.dropbox.com/s/wclbvga9x50i0wv/recipes.xml?raw=1';
	public $filepath;
	public $backuppath;

	public function __construct() {
		$this->filepath = storage_path('data/recipes/recipes.xml');
		$this->backuppath = storage_path('data/recipes/recipes.back.xml');
	}

	public function update() {
		//// retrieve latest file
		$xml = $this->get();
		//// validate xml
		if (!$this->verify($xml)) {
			throw new \RuntimeException('Invalid XML');
		}
		//// retrieve current version
		$current = file_get_contents($this->filepath);
		//// check if contents have changed
		if ($xml === $current) {
			//// write to cache, if not already there
			if (!Cache::has(self::CACHE_KEY)) {
				$data = $this->parse();
				$this->cache($data);
			}
			return 'Files are same';
		}
		//// back up last version
		copy($this->filepath, $this->backuppath);
		//// overwrite with new data
		file_put_contents($this->filepath, $xml);
		//// parse to object
		$data = $this->parse();
		//// cache the result
		$this->cache($data);
		Log::info('Updated recipes');
		return 'Updated recipes';

	}

	public function cache($data) {
		Cache::forget(self::CACHE_KEY);
		Cache::forever(self::CACHE_KEY, $data);		
	}


	public function get() {
		////magic to get data;

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_FAILONERROR,1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);        

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);
        // close curl resource to free up system resources
        curl_close($ch); 		
        return $output;
	}

	public function verify($xml) {
		//// verify xml
		$regex = '/<\?xml version="1.0" encoding="UTF-8"\?>[\s\n]+<!DOCTYPE gourmetDoc>[\s\n]+<gourmetDoc>/';
		return preg_match($regex, $xml);
	}

    public function parse() : array {
		$xml = simplexml_load_file($this->filepath);
		if (!$xml) {	
			throw new \RuntimeException('Error reading recipes XML file');
		}        
        $recipes = [];
        foreach ($xml as $recipe) {
            $json = [
                'id' => (string) $recipe['id'],
                'instructions' => explode("\n", (string) $recipe->instructions)
            ];
            if ($recipe->modifications && strlen(trim((string) $recipe->modifications)) > 0) {
                $json['notes'] = explode("\n", (string) $recipe->modifications);
            }
            //// simple tags
            $tagnames = ['title', 'category','cuisine','rating','preptime','servings','cooktime'];
            foreach ($tagnames as $tagname) {
                $json[$tagname] = (string)$recipe->{$tagname};
            }
            //// instructions
            $ingredients = [];
            foreach ($recipe->{'ingredient-list'}->ingredient as $ingredient) {
                $ingredients[] = [
                    'amount' => (string) $ingredient->amount,
                    'unit' => (string) $ingredient->unit,
                    'item' => (string) $ingredient->item,
                    'key' => (string) $ingredient->key
                ];
            }
            $ingredients = [];
            foreach ($recipe->{'ingredient-list'}->ingredient as $ingredient) {
                $ingredients[] = [
                        'amount' => (string) $ingredient->amount,
                        'unit' => (string) $ingredient->unit,
                        'item' => (string) $ingredient->item,
                        'key' => (string) $ingredient->key
                ];
            }
            $json['ingredients'] = $ingredients;
            $recipes[] = $json;
        }
        return $recipes;
    }	
}
