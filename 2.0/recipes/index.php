<style type="text/css">
div.recipe {
	padding-bottom: 2em;
}


div.recipe td, div.recipe th {
	padding-top: 0;
	padding-bottom: 0;
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
$h->tbr('This page came about because I wanted something to do using XML, when ' . 
"I hadn't found a practical use for it (I've found plenty since). Somehow " .
"the recipe idea seemed like a good fit. Since then, I haven't devoted " .
'much time to it. There are all sorts of things like ' .
'<a href="http://allrecipes.com/">allrecipes.com</a> ' .
'and <a href"http://www.epicurious.com/">epicurious.com</a>, ' .
"so there's not a clear need. So it's got sentimental value, I guess." .
'But then I found this desktop recipe manager, . ' .
'<a href="http://grecipe-manager.sourceforge.net/">Gourmet</a> ' .
"I liked the idea that it stored my data locally and could use XML to " .
"export and import data. I wrote a script to convert my XML to their XML and " .
"exported all my recipes from my XML file into Gourmet, added recipes, modified " .
" ... to be continued or edited or something, just wanted to get something up"
);

// displays all the file nodes
if(!$xml=simplexml_load_file($filedir . 'recipes0904.grmt')){
    trigger_error('Error reading XML file',E_USER_ERROR);
}

include_once($filedir . 'Recipes.php.inc');







/***********************
 * Start Display
 *********************/

$h->div("", 'id="top"');
$h->odiv('id="menu"');
foreach ($xml as $recipe) {
	$thisRecipe = new Recipe($recipe);
	$title = trim($recipe->title);
	//$h->tbr($title . " " . $thisRecipe->getName($title));
	$h->a("#" . $thisRecipe->getName($title), $title);	
	$h->br();
	
}
$h->cdiv();
foreach ($xml as $recipe) {
	$thisRecipe = new Recipe($recipe);
	$thisRecipe->display();
	$h->local($webdir."/recipes/printable.php&id=".$recipe['id'], "Print", 'target="_blank"');
	$h->br(2);
	$h->local($webdir."/recipes/export.php&id=".$recipe['id'], "Export");
	$h->br(2);
	$h->a("#top", "Return to top");
	$h->br(2);
}

?>

<?php


/*
$xml = $GLOBALS['fileroot'] . "/recipes/recipes2.xml";

if (isset($_GET['recipe'])) {
	writeRecipe($_GET['recipe']);
		$xslt = "print_recipe.xsl";
}
else $xslt = $GLOBALS['fileroot'] . "/recipes/recipes2.xsl";

// create a new XSLT processor
$xp = xslt_create();

// transform the XML file as per the XSLT stylesheet
// return the result to $result
$result = xslt_process($xp, $xml, $xslt);
if ($result) 
{
	// print it
	echo $result;
} else {
	echo "must have been some error" . xslt_errno($xp) . " " . xslt_error($xp);
}

// clean up
xslt_free($xp);

function writeRecipe($recipe) {
	touch("print_recipe.xsl", 0777) or die("Can't touch");
	$writer = fopen("print_recipe.xsl", "w") or die("Can't write");
	fwrite($writer, "<?xml version=\"1.0\"?>\n");
	fwrite($writer, "<xsl:stylesheet xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\" version=\"1.0\">\n");
	fwrite($writer, "<xsl:template match=\"/\">\n");
	fwrite($writer, "<html>\n");
	fwrite($writer, "<head>\n");
	fwrite($writer, "	<title>$recipe</title>\n</head>\n<body>\n");
	fwrite($writer, "		<xsl:apply-templates select=\"recipes/recipe\" />\n");
	fwrite($writer, "	</body>\n");
	fwrite($writer, " </html>\n");
	fwrite($writer, "</xsl:template>\n");
	
	fwrite($writer, "<xsl:template match=\"recipe\">\n");
	fwrite($writer, "<xsl:if test=\"name='$recipe'\">\n");
	fwrite($writer, "<h2><xsl:value-of select=\"name\" /></h2>\n");
	fwrite($writer, "<p>\n");
	fwrite($writer, "<xsl:apply-templates select=\"ingredients\" />\n");
	fwrite($writer, "<xsl:apply-templates select=\"directions\" />\n");
	fwrite($writer, "</p>\n");
	fwrite($writer, "</xsl:if>\n");
	fwrite($writer, "</xsl:template>\n");
	
	fwrite($writer, "<xsl:template match=\"ingredients\">\n");
	fwrite($writer, "<ul>\n");
	fwrite($writer, "<xsl:for-each select=\"ingredient\">\n");
	fwrite($writer, "<li><xsl:value-of select=\"type\" />--<xsl:value-of select=\"quantity\" /></li>\n");
	fwrite($writer, "</xsl:for-each>\n");
	fwrite($writer, "</ul>\n");
	fwrite($writer, "</xsl:template>\n");
	
	fwrite($writer, "<xsl:template match=\"directions\">\n");
	fwrite($writer, "<ol>\n");
	fwrite($writer, "<xsl:for-each select=\"step\">\n");
	fwrite($writer, "<li><xsl:value-of select=\".\" /></li>\n");
	fwrite($writer, "</xsl:for-each>\n");
	fwrite($writer, "</ol>\n");
	fwrite($writer, "</xsl:template>\n");
	fwrite($writer, "</xsl:stylesheet>\n");
}
*/
?>
