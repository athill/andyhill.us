<?php
namespace App\Services;

class RecipeService {
  private $url = 'https://www.dropbox.com/s/wclbvga9x50i0wv/recipes.xml?raw=1';
  private $xml;

  public function __construct() {
    $this->xml = $this->getXml();
  }

  public function get() {
    return $this->parse($this->xml);
  }




	public function getXml() {
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
    return simplexml_load_string($output);
  }

  private function parse($xml) : array {
		if (!$xml) {
			throw new \RuntimeException('Error reading recipes XML file');
		}
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);

    $recipes = [];
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
    }
    return $recipes;
  }
}
