<?php
require_once("../inc/setup.inc.php");
$page = new Page(array(
	'stylesheets'=>array('recipes.css')
));

require_once('Api.php');
$api = new Api('recipes.xml');

// if(!$xml=simplexml_load_file('recipes0904.grmt')){
//     trigger_error('Error reading XML file',E_USER_ERROR);
// }

// if(!$xml=simplexml_load_file('recipes.xml')){
//     trigger_error('Error reading XML file',E_USER_ERROR);
// }

$xml = $api->getXml();

include_once('Recipe.class.php');

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
and <a href="http://www.epicurious.com/" target="_blank">epicurious.com</a>,
so there's not a clear need. So it's got sentimental value, I guess.
But then I found this desktop recipe manager, 
<a href="http://thinkle.github.io/gourmet/" target="_blank">Gourmet</a> 
I liked the idea that it stored my data locally and could use XML to 
export and import data. I wrote a script to convert my XML to their XML you 
can export these recipes into Gourmet
</p>

<p>
The filtering system is completely based on XPATH: Both populating the options 
and the results.
</p>

EOD;
$page->template->template->geekOut($intro);


$h->p('I use the excellent <a href="http://thinkle.github.io/gourmet/" target="_blank">Gourmet</a> recipe manager. If you use Gourmet as well, you can export these recipes (click on "Export" below the recipe) and import them into Gourmet');

///////////////////////
////Filter
/////////////////////////
////Build drop-down options
$ingredients = $api->getIngredients();
$categories = $api->getCategories();
$cuisines = $api->getCuisines();

////render form
$h->oform("", 'get', 'class="form-inline"');
$h->ofieldset("Filter");
// $filters = array(
// 	array( 'id'=>'category', 'options'=> $categories),
// 	array( 'id'=>'cuisine', 'options'=> $cuisines),
// 	array( 'id'=>'ingredient', 'options'=> $ingredients),
// );
$filters = array(
	array( 'id'=>'category', 'options'=> []),
	array( 'id'=>'cuisine', 'options'=> []),
	array( 'id'=>'ingredient', 'options'=> []),
);

foreach ($filters as $filter) {
	$h->odiv('class="form-group"');
	$h->label($filter['id'], "<strong>".ucfirst($filter['id']).": </strong>");
	$h->select($filter['id'], [], $h->getVal($filter['id']), ['class' => 'form-control']);
	$h->cdiv(); //// .form-group

}
$h->br();
$h->label('filter', '<strong>Any: </strong>');
$h->intext('filter');
//$h->input("reset", "s", "Clear");
$h->cfieldset();
$h->cform();


// <form class="form-inline">
//   <div class="form-group">
//     <label for="exampleInputName2">Name</label>
//     <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
//   </div>
//   <div class="form-group">
//     <label for="exampleInputEmail2">Email</label>
//     <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
//   </div>
//   <button type="submit" class="btn btn-default">Send invitation</button>
// </form>



/////////////////////////////////
////Menu
///////////////////////////////
$h->linkList([], 'id="menu"');
/////////////////////////
////Recipes
///////////////////////////
$h->div('', 'id="recipes"');

$h->script('var recipes = '.$api->exportJson());
$h->scriptfile('recipes.js');
$page->end();
?>
