<?php
$local['stylesheets'] = array('recipes.css');
include_once("../inc/application.php");
if(!$xml=simplexml_load_file('recipes0904.grmt')){
    trigger_error('Error reading XML file',E_USER_ERROR);
}

include_once('Recipes.class.php');

$h->div("", 'id="top"');
///////////////////////
//// Intro
///////////////////////
$intro = <<<EOD
<p>
This page came about because I wanted something to do using XML, when 
I hadn't found a practical use for it (I've found plenty since). Somehow 
the recipe idea seemed like a good fit. Since then, I haven't devoted 
much time to it. There are all sorts of things like 
<a href="http://allrecipes.com/">allrecipes.com</a> 
and <a href"http://www.epicurious.com/" target="_blank">epicurious.com</a>,
so there's not a clear need. So it's got sentimental value, I guess.
But then I found this desktop recipe manager, 
<a href="http://grecipe-manager.sourceforge.net/" target="_blank">Gourmet</a> 
I liked the idea that it stored my data locally and could use XML to 
export and import data. I wrote a script to convert my XML to their XML you 
can export these recipes into Gourmet
</p>

<p>
The filtering system is completely based on XPATH: Both populating the options 
and the results.
</p>

EOD;
$template->template->geekOut($intro);


///////////////////////
////Filter
/////////////////////////
////Build drop-down options
$ingredients = getOptions($xml->xpath('//ingredient/item'));
$categories = getOptions($xml->xpath('//category'));
$cuisines = getOptions($xml->xpath('//cuisine'));

////helper
function getOptions($result) {
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
////render form
$h->oform("", 'get');
$h->ofieldset("Filter");
$filters = array(
	array( 'id'=>'category', 'options'=> $categories),
	array( 'id'=>'cuisine', 'options'=> $cuisines),
	array( 'id'=>'ingredient', 'options'=> $ingredients),
);
foreach ($filters as $filter) {
//	$h->pa($filter);
	$h->label($filter['id'], "<strong>".ucfirst($filter['id']).": </strong>");
	$h->select($filter['id'], $filter['options'], $h->getVal($filter['id']));

}
//$h->input("reset", "s", "Clear");
$h->input("submit", "s", "Submit");
$h->cfieldset();
$h->cform();

if (array_key_exists('s', $_GET)) {
	$filters = array(
		'category' => array('root'=>'recipe', 'field'=>'category', 'suffix'=>''),
		'cuisine' => array('root'=>'recipe', 'field'=>'cuisine', 'suffix'=>''),
		'ingredient' => array('root'=>'recipe/ingredient-list/ingredient', 'field'=>'item'
			, 'suffix'=>'/ancestor::*')
	);
	$query = "";
	foreach ($filters as $k => $v) {
		if (array_key_exists($k, $_GET) && $_GET[$k] != "") {
			if ($query != "") {
				$query .= " | ";
			}
			$query .= $v['root'].'[normalize-space('.$v['field'].') = normalize-space("'.$_GET[$k].'")]'.$v['suffix'];
		}
	}
	if ($query != "") {
		$result = $xml->xpath($query);
		$xml = $result;	
//		$h->pa($result); 
	}
}



/////////////////////////////////
////Menu
///////////////////////////////
$h->odiv('id="menu"');
$links = array();
foreach ($xml as $recipe) {
	$thisRecipe = new Recipe($recipe);
	$title = trim($recipe->title);
	if ($title != "") {
		$links[] = array('href' => "#" . $thisRecipe->getName($title), 'display'=> $title);
	}
}
$h->linkList($links);
$h->cdiv();	////close menu
/////////////////////////
////Recipes
///////////////////////////
$h->odiv('id="recipes"');
foreach ($xml as $tagname => $recipe) {
	$thisRecipe = new Recipe($recipe);
//	$h->pa($recipe);
	if ($recipe->title != "") {
		$thisRecipe->display();
		$h->a("printable.php?id=".$recipe[0]['id'], "Print", 'target="_blank"');
		$h->tnl(" | ");
		$h->a("export.php?id=".$recipe[0]['id'], "Export");
		$h->br(2);
		$h->a("#top", "Return to top");
		$h->br(2);
	}
}
$h->cdiv(); ////close recipes
$template->footer();

?>
