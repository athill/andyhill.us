<?php
require_once('Recipe.class.php');

class Api {

	private $xml;

	const PARAMETER_SEARCH_TEMPLATE = '%s[normalize-space(%s) = normalize-space("%s")]%s';

	public function __construct($xmlFilePath) {
		if(!$this->xml=simplexml_load_file($xmlFilePath)){
 		   trigger_error('Error reading XML file',E_USER_ERROR);
		}
	}

	public function getXml() {
		return $this->xml;
	}

	public function exportJson() {
		$json = [];
		foreach ($this->xml as $recipe) {
			$thisRecipe = new Recipe($recipe);
			$json[] = $thisRecipe->getJson();
		}
		return json_encode($json);
	}

	public function getIngredients() {
		return $this->getOptions('//ingredient/item');
	}

	public function getCategories() {
		return $this->getOptions('//category');
	}

	public function getCuisines() {
		return $this->getOptions('//cuisine');
	}

	public function searchByParams($params)	{
		$filters = array(
			'category' => array('root'=>'recipe', 'field'=>'category', 'suffix'=>''),
			'cuisine' => array('root'=>'recipe', 'field'=>'cuisine', 'suffix'=>''),
			'ingredient' => array('root'=>'recipe/ingredient-list/ingredient', 'field'=>'item'
				, 'suffix'=>'/ancestor::*')
		);
		$queries = [];
		foreach ($filters as $k => $v) {
			if (array_key_exists($k, $params) && $params[$k] != "") {
				// $query .= $v['root'].'[normalize-space('.$v['field'].') = normalize-space("'.$params[$k].'")]'.$v['suffix'];
				$queries[] = $this->getParameterXpath($v['root'], $v['field'], $params[$k], $v['suffix']);
			}
		}
		if (count($queries) > 0) {
			return $this->xml->xpath(implode(' | ', $queries));
		}
	// 	if ($query != "") {
	// 		$result = $this->xml->xpath($query);
	// 		return $result;
	// //		$h->pa($result); 
	// 	} 
		return $this->xml;
	}

	private function getParameterXpath($root, $field, $value, $suffix='') {
		return sprintf(self::PARAMETER_SEARCH_TEMPLATE, $root, $field, $value, $suffix);
	}

	private function getOptions($xpath) {
		$result = $this->xml->xpath($xpath);
		$items = array();
		foreach ($result as $item) {
			$item = trim((string)$item);
			$pos = strpos($item, ';');
			if ($pos !== false) {
				$item = substr($item, 0, $pos);
			}
			$item = $item."|".ucfirst($item);
			$item = str_replace('"', '&quot;', $item);
			if (!in_array($item, $items)) {
				$items[] = $item;
			}
		}
		sort($items);
		array_unshift($items, "");
		return $items;
	}	
}