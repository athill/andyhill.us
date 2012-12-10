<?php
$local['template'] = "Basic";
include('../inc/application.php');

if(!$xml=simplexml_load_file('recipes0904.grmt')){
    trigger_error('Error reading XML file',E_USER_ERROR);
}
include_once('Recipes.class.php');
$id = $_GET['id'];
$recipes = $xml->xpath("//recipe[@id=$id]");
if (count($recipes) > 0) {
	$recipe = new Recipe($recipes[0]);
	$recipe->display();
} else {
	$h->div('Error: Bad id', 'class="error"');
}
$template->footer();
?>
