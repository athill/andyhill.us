<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:template match="/">
<html>
<head>
	<title>Sweet Potato Burritos</title>
</head>
<body>
		<xsl:apply-templates select="recipes/recipe" />
	</body>
 </html>
</xsl:template>
<xsl:template match="recipe">
<xsl:if test="name='Sweet Potato Burritos'">
<h2><xsl:value-of select="name" /></h2>
<p>
<xsl:apply-templates select="ingredients" />
<xsl:apply-templates select="directions" />
</p>
</xsl:if>
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
