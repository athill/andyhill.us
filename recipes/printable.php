<?php
include('../inc/setup.inc.php');
$page = new Page(array(
	'template'=>'Basic',
	'stylesheets' => ['css/boostrap/css/bootstrap.min.css', 'recipes.css']
));

if(!$xml=simplexml_load_file('recipes.xml')){
    trigger_error('Error reading XML file',E_USER_ERROR);
}
include_once('Recipes.class.php');
$id = $_GET['id'];
$recipes = $xml->xpath("//recipe[@id=$id]");
if (count($recipes) > 0) {
	$recipe = new Recipe($recipes[0]);
	$h->div('', ['id' => 'recipe']);
	// $recipe->display();
	$h->script('var recipe = '.$recipe->exportJson());
	$h->scriptfile(['util.js', 'printable.js']);
} else {
	$h->div('Error: Bad id', 'class="error"');
}

$page->end();
?>
