<style type="text/css">
div.recipe {
	padding-bottom: 2em;
}

div.recipe h2, div.recipe h3 {
	margin: 0;
	paadding: 0;
}

div#menu a {
	padding: .3em;
	font-size: 1.5em;
}


</style>



<?php
// displays all the file nodes
if(!$xml=simplexml_load_file($fileroot . '/recipes/recipes.grmt')){
    trigger_error('Error reading XML file',E_USER_ERROR);
}



function getName($name) {
	return preg_replace("/[^a-zA-Z0-9]/", "", $name);
}



/***********************
 * Start Display
 *********************/

$h->div("", 'id="top"');
$h->odiv('id="menu"');
foreach ($xml as $recipe) {
	$title = trim($recipe->title);
	$h->a("#" . getName($title), $title);
	$h->br();
	
}
$h->cdiv();
foreach ($xml as $recipe) {
	$h->odiv('class="recipe"');
	$title = trim($recipe->title);	
	$h->h(2, $title, 'id="'. getName($title).'"');
	$h->otable();
	$items = array("Category,category",
			"Style,cuisine",
			"Rating,rating",
			"Prep Time,preptime",
			"Servings,servings",
			"Cook Time,cooktime",
	);
	for ($i = 1; $i < count($items); $i++) {
		$item = explode(",", $items[$i]);
		$h->th($item[0].":");
		$h->td(trim($recipe->$item[1]));
		if ($i < count($items) - 1) $h->cotr();
	}
	$h->ctable();		
	////Ingrdeients
	$h->h(3, "Ingredients:");
	$thing = "ingredient-list";
	$columns = explode(",", "amount,unit,item");
	$h->otable();
	$count = 0;
	$size = count($recipe->$thing->ingredient);
	foreach ($recipe->$thing->ingredient as $ingredient) {
		$count++;
		foreach ($columns as $column) {
			$h->td(trim($ingredient->$column));	
		}
		if ($count < $size) $h->cotr();
	}
	$h->ctable();
	////Instructions	
	$h->h(3, "Instructions:");
	$instructions = preg_replace("/\n/", "<br />\n", trim($recipe->instructions));
	$h->op($instructions);	
	$h->br(2);
	$h->a("#top", "Return to top");
	$h->cdiv();
}




exit(1);
$count = 0;
print('<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE gourmetDoc>
<gourmetDoc>'. "\n");

foreach ($xml as $recipe) {
	
	$count++;
	output("\t<recipe id=\"$count\">\n");
	output("\t\t<title>$recipe->name</title>\n");
	output("\t\t<category>Entree</category>\n");
	output("\t\t<cuisine>$recipe->region</cuisine>\n");
	output("\t\t<rating>4/5 stars</rating>\n");

	output("\t\t<preptime></preptime>\n");
	output("\t\t<cooktime></cooktime>\n");
	output("\t\t<servings>4-6</servings>\n");
	output("\t\t<ingredient-list>\n");
//	echo 'Name: '.$recipe->name.' Address: '.$recipe->region.'<br />'. "\n";
	for ($i = 0; $i < count($recipe->ingredients->ingredient); $i++) {
		output("\t\t\t<ingredient>\n");		
		$type = $recipe->ingredients->ingredient[$i]->type;
		$quantity = $recipe->ingredients->ingredient[$i]->quantity;
		$q = explode(" ", $quantity);
		$amount = $q[0];
		if (count($q) > 1) $unit = $q[1];
		else $unit = "";
		$unit = preg_replace("/t\.? */", "tsp. ", $unit); 
		$unit = preg_replace("/T\.? */", "Tsp. ", $unit); 
		output("\t\t\t\t<amount>$amount</amount>\n");
		output("\t\t\t\t<unit>$unit</unit>\n");
		
		$item = ucwords(preg_replace("/,/", ";", $type));
		if (preg_match("/;/", $item)) {
			list($thing, $comment) = explode(";", $item);
			$key = strtolower($thing);
		} else {
			$key = strtolower($type);
		}
		output("\t\t\t\t<item>$item</item>\n");
		output("\t\t\t\t<key>$key</key>\n");
		
		output("\t\t\t</ingredient>\n");		

	}
	output("\t\t</ingredient-list>\n");
	output("\t\t<instructions>\n");
	$instructions = "";
	for ($i = 0; $i < count($recipe->directions->step); $i++) {
		$instructions .= $recipe->directions->step[$i] . "\n";
	}
	output("$instructions\n");
	output("\t\t</instructions>\n");
	//print("****************************<br />\n");
	output("\t</recipe>\n");
	
}
output("</gourmetDoc>");


function output($str) {
	print($str);
}
?>
