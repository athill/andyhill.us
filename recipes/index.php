<?php
require_once("../inc/setup.inc.php");
$page = new Page(array(
	'stylesheets'=>array('recipes.css')
));

require_once('Api.php');
$api = new Api('recipes.xml');


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
The filtering system uses jQuery. 
</p>

EOD;
$page->template->template->geekOut($intro);


$h->p('I use the excellent <a href="http://thinkle.github.io/gourmet/" target="_blank">Gourmet</a> recipe manager. If you use Gourmet as well, you can export these recipes (click on "Export" below the recipe) and import them into Gourmet');

///////////////////////
////Filter
/////////////////////////

////render form
$h->oform("", 'get', ['class' => 'form-inline', 'id' => 'filter-form']);
$h->ofieldset("Filter");
$h->odiv(['class' => 'form-group']);
$h->label('filter', '<strong>Text: </strong>');
$h->intext('filter', '', ['class' => 'form-control', 'size' => '10']);
$h->cdiv('./form-group');
$filters = ['category', 'cuisine', 'ingredient'];
foreach ($filters as $filter) {
	$h->odiv('class="form-group"');
	$h->label($filter, "<strong>".ucfirst($filter).": </strong>");
	$h->select($filter, [], '', ['class' => 'form-control']);
	$h->cdiv(); //// .form-group

}

$h->cfieldset();
$h->cform();

/////////////////////////////////
////Menu
///////////////////////////////
$h->linkList([], 'id="recipe-list"');
/////////////////////////
////Recipes
///////////////////////////
$h->div('', 'id="recipes"');

$h->script('var recipes = '.$api->exportJson());
$h->scriptfile(['util.js', 'indexjs.js']);

$page->end();
