<?php
if(!$xml=simplexml_load_file($filedir . '/recipes0904.grmt')){
    trigger_error('Error reading XML file',E_USER_ERROR);
}

include_once($filedir . '/Recipes.php.inc');
$id = $_GET['id'];
$recipes = $xml->xpath("//recipe[@id=$id]");
$recipe = new Recipe($recipes[0]);
$recipe->export();

?>
