<?php
namespace App\Services;

use App\Utils;

class RecipeService {
  private $url = 'https://www.dropbox.com/s/wclbvga9x50i0wv/recipes.xml?raw=1';
  private $xml;
  private $logger;
  private $cacheKey = 'recipes';
  private $xmlCacheKey = 'recipes-xml';
  private $expireSeconds = 86400;

  public function __construct() {
    $this->logger =  Utils::getLogger();
    $this->cache = Utils::getCache();
    $cached = $this->cache->get($this->xmlCacheKey);
    $cached = null;
    if (!is_null($cached)) {
      $this->logger->info('returning recipes xml from cache');
      $this->xml = $cached;
    } else {
      $this->logger->info('fetching recipes xml');
      $this->xml = file_get_contents($this->url);
      $this->cache->set($this->xmlCacheKey, $this->xml, $this->expireSeconds);
    }
  }

  public function get() {
    return $this->getDate();
  }

  public function print($id) {
    $data = $this->getData();
    foreach ($data as $recipe) {
      if ($recipe['id'] === $id) {
          return view('print-recipe', ['recipe' => $recipe]);
      }
    }
  }

  public function export($id) {
    $simpleXml = simplexml_load_string($this->xml);
    $content = $simpleXml->xpath("//recipe[@id=$id]");
    $recipe = $content[0]->asXml();
    return <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE gourmetDoc>
<gourmetDoc>
  $recipe
</gourmetDoc>
EOD;
  }

  private function getData() {
    $cached = $this->cache->get($this->cacheKey);
    if (!is_null($cached)) {
        $this->logger->info('returning cached recipes');
        return json_decode($cached, true);
    }
    $this->logger->info('parsing recipes');
    $simpleXml = simplexml_load_string($this->xml);
    $response =  $this->parse($simpleXml);
    $this->cache->set($this->cacheKey, json_encode($response), $this->expireSeconds);
    return $response;
  }



  private function parse($xml) : array {
		if (!$xml) {
			throw new \RuntimeException('Error reading recipes XML file');
		}
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);

    $recipes = [];
    $categories = [];
    $cuisines = [];
    $ingredients = [];
    foreach ($array['recipe'] as $recipe) {
      $json = [
          'id' => $recipe['@attributes']['id'],
          'instructions' => isset($recipe['instructions']) ? explode("\n", $recipe['instructions']) : '',
        'servings' => isset($recipe['yields']) ? $recipe['yields'] : ''
      ];
      if (isset($recipe['modifications']) && strlen(trim($recipe['modifications'])) > 0) {
          $json['notes'] = explode("\n", $recipe['modifications']);
      }
      //// simple tags
      $tagnames = ['category','cooktime','cuisine','link','preptime','rating','source','title'];
      foreach ($tagnames as $tagname) {
          $json[$tagname] = isset($recipe[$tagname]) ? trim($recipe[$tagname]) : '';
      }   
      //// instructions
      $json['ingredients'] = isset($recipe['ingredient-list']) ? $recipe['ingredient-list']['ingredient']: '';
      $recipes[] = $json;
      $category = trim($json['category']);
      $option = $this->getOption($category);
      if ($category !== "" && !in_array($option, $categories)) {
        $categories[] = $this->getOption($category);
      }
      $cuisine = trim($json['cuisine']);
      $option = $this->getOption($cuisine);
      if ($cuisine !== "" && !in_array($option, $cuisines)) {
        $cuisines[] = $option;
      }      
    }
    sort($categories);
    sort($cuisines);
    return [
      'categories' => $categories,
      'cuisines' => $cuisines,
      'igredients' => $ingredients,
      'recipes' => $recipes
    ];
  }

  private function getOption($option) {
    return [
      'display' => $option,
      'value' => $option
    ];
  }
}
