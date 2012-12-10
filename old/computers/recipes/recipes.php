<?php
$xml = "recipes2.xml";

if (isset($_GET['recipe'])) {
	writeRecipe($_GET['recipe']);
	$xslt = "print_recipe.xsl";
}
else $xslt = "recipes.xsl";

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

?>