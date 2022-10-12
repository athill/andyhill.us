<?php
namespace App\Services;

use App\Utils;

class RecipeService {
  private $url = 'https://www.dropbox.com/s/wclbvga9x50i0wv/recipes.xml?raw=1';
  private $xml;
  private $logger;

  public function __construct() {
    $this->logger =  Utils::getLogger();
    $this->xml = $this->getXml();
  }

  public function get() {
    return $this->parse($this->xml);
  }

	public function getXml() {
    $output = file_get_contents($this->url);
    return simplexml_load_string($output);
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
          $json[$tagname] = isset($recipe[$tagname]) ? $recipe[$tagname] : '';
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
