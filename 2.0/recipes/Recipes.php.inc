<?php

/**
 * REcipe manager using .gmrt XML files
 *
 * 
 *
 * @package includes
 * @author andy hill 1 2009
 * @version 1.0
 *
 */

class Recipe {
	 	
 	/**
	 * Recipe object
	 *
	 */  
 	var $recipe;

	var $h;	//html object

 	function __construct($recipe) {
 		$this->recipe       = $recipe;
		$this->h = Html::singleton();
 	}

	function export($output=true) {
		if (!$output) $this->h->startBuffer();		
		$this->startXML();
		$this->h->op($this->recipe->asXML());
		$this->endXML();
	}

	private function startXML() {
		header("Content-type: text/xml");
		$this->h->tnl('<?xml version="1.0" encoding="UTF-8"?>');
		$this->h->tnl('<!DOCTYPE gourmetDoc>');
		$this->h->tnl('<gourmetDoc>');
	}

	private function endXML() {
		$this->h->top('</gourmetDoc>');
	}

	public function display() {
		$this->h->odiv('class="recipe"');
		$title = trim($this->recipe->title);	
		$this->h->h(2, $title, 'id="'. $this->getName($title).'"');
		$this->h->otable();
		$items = array("Category,category",
				"Style,cuisine",
				"Rating,rating",
				"Prep Time,preptime",
				"Servings,servings",
				"Cook Time,cooktime",
		);
		for ($i = 1; $i < count($items); $i++) {
			$item = explode(",", $items[$i]);
			$this->h->th($item[0].":");
			$this->h->td(trim($this->recipe->$item[1]));
			if ($i < count($items) - 1) $this->h->cotr();
		}
		$this->h->ctable();		
		////Ingrdeients
		$this->h->h(3, "Ingredients:");
		$columns = explode(",", "amount,unit,item");
		$this->h->otable();
		$count = 0;
		$ingredients = $this->recipe->{'ingredient-list'}->ingredient;
		$size = count($ingredients);
		foreach ($ingredients as $ingredient) {
			$count++;
			foreach ($columns as $column) {
				$this->h->td(trim($ingredient->$column));	
			}
			if ($count < $size) $this->h->cotr();
		}
		$this->h->ctable();
		////Instructions	
		$this->h->h(3, "Instructions:");
		$instructions = preg_replace("/\n/", "<br />\n", trim($this->recipe->instructions));
		$this->h->op($instructions);	
		$this->h->cdiv();
	}

	function getName($name) {
		//$this->h->tbr($name);
		return preg_replace("/[^a-zA-Z0-9]/", "", $name);
	}
	
}
?>
