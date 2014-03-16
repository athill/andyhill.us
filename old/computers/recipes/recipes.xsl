<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:template match="/">
	<html>
	<head>
	<title>Andy's recipes</title>
	<link rel="stylesheet" href="styles.css" class="text/css" />
	</head>
	<body>
	<a name="top"></a>
	<a href="add_recipe.php">Add a recipe</a><br /><br />
	<xsl:apply-templates select="recipes/recipe/name" />
	<xsl:apply-templates select="recipes/recipe" /> 
	</body>
 	</html>
</xsl:template>

<xsl:template match="name">
<a>
  <xsl:attribute name="href">#<xsl:value-of select="translate(., ' ', '_')" />
  </xsl:attribute>
  <xsl:value-of select="." />
</a>
<br />
</xsl:template>

<xsl:template match="recipe">
<a>
	<xsl:attribute name="name"><xsl:value-of select="translate(name, ' ', '_')"/>
  </xsl:attribute>	
</a>
<h2><xsl:value-of select="name" /></h2>
<p>
<xsl:apply-templates select="ingredients" />
<xsl:apply-templates select="directions" />
<a>
	<xsl:attribute name="href">recipes.php?recipe=<xsl:value-of select="name" /></xsl:attribute>
	<xsl:attribute name="target">_blank</xsl:attribute>
	Print-friendly recipe
</a>
<br /><br />
<a href="#top">Return to top</a>
</p>
</xsl:template>

<xsl:template match="ingredients">
<ul>
<xsl:for-each select="ingredient">
<li><xsl:value-of select="type" />--<xsl:value-of select="quantity" /></li>
</xsl:for-each>
</ul>
</xsl:template>

<xsl:template match="directions">
<ol>
<xsl:for-each select="step">
<li><xsl:value-of select="." /></li>
</xsl:for-each>
</ol>
</xsl:template>
</xsl:stylesheet>
