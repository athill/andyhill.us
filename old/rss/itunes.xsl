<?xml version="1.0"?>

<xsl:stylesheet  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
xmlns:rss="http://purl.org/rss/1.0/"
xmlns:dc="http://purl.org/dc/elements/1.1/" version="1.0"
xmlns:itms="http://phobos.apple.com/rss/1.0/modules/itms/">



<!-- main page -->
<xsl:template match="/">
	<html>
	<head>
	<basefont face="Arial" size="1"/>
	</head>
	<body>
	<h4>Soundslam New Releases</h4>
	<table>
	<xsl:apply-templates select="//item" />
	</table>
	</body>
	</html>
</xsl:template>



<!-- item -->
<xsl:template match="item">
 <tr>
 	<td>
	<a>
	<xsl:attribute name="href"><xsl:value-of select="link" /></xsl:attribute>
	<xsl:apply-templates select="itms:coverArt" />
	</a>
	</td>
	<td>
	<a>
	<xsl:attribute name="href"><xsl:value-of select="link" /></xsl:attribute>
	<xsl:value-of select="title" />
	</a>
	</td>
</tr>
</xsl:template>

<xsl:template match="itms:coverArt">
<xsl:if test="@height=53">
<img>
	<xsl:attribute name="src"><xsl:value-of select="." /></xsl:attribute>
</img>
</xsl:if>
</xsl:template>



</xsl:stylesheet>