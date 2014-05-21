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


 	function __construct($recipe) {
 		$this->recipe       = $recipe;
 	}

	function export($output=true) {
		global $h;
		if (!$output) $h->startBuffer();		
		$this->startXML();
		$h->tnl($this->recipe->asXML());
		$this->endXML();
	}

	private function startXML() {
		global $h;
		// header("Content-type: text/xml");
		$h->wonl('<?xml version="1.0" encoding="UTF-8"?>');
		$h->tnl('<!DOCTYPE gourmetDoc>');
		$h->otag('gourmetDoc');
	}

	private function endXML() {
		global $h;
		$h->ctag('gourmetDoc');
	}

	public function display() {
		global $h;
		$h->odiv('class="recipe"');
		$title = trim($this->recipe->title);	
		$h->h(2, $title, 'id="'. $this->getName($title).'"');
		$h->otable();
		$items = array("Category,category",
				"Style,cuisine",
				"Rating,rating",
				"Prep Time,preptime",
				"Servings,servings",
				"Cook Time,cooktime",
		);
//		$h->pa($this->recipe);
		/*
		for ($i = 1; $i < count($items); $i++) {
			$item = explode(",", $items[$i]);
			$h->th($item[0].":");
			$h->td(trim($this->recipe->$item[1]));
			if ($i < count($items) - 1) $h->cotr();
		}
		*/
		foreach ($items as $i => $item) {
			list($label, $tagname) = explode(",", $item);
//			$h->tbr($label);
			$h->th($label . ": ");
			$h->td(trim($this->recipe->{$tagname}));
			if ($i < count($items) - 1) $h->corow();
		}
		$h->ctable();		
		////Ingrdeients
		$h->h(3, "Ingredients:");
		$columns = explode(",", "amount,unit,item");
		$h->otable();
		$count = 0;
		$ingredients = $this->recipe->{'ingredient-list'}->ingredient;
		$size = count($ingredients);
		foreach ($ingredients as $ingredient) {
			$count++;
			foreach ($columns as $column) {
				$h->td(trim($ingredient->$column));	
			}
			if ($count < $size) $h->corow();
		}
		$h->ctable();
		////Instructions	
		$h->h(3, "Instructions:");
		$instructions = preg_replace("/\n/", "<br />\n", trim($this->recipe->instructions));
		$h->op($instructions);	
		$h->cdiv();
	}

	function getName($name) {
		//$h->tbr($name);
		return preg_replace("/[^a-zA-Z0-9]/", "", $name);
	}
	
}
?>