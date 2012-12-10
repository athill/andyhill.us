<?xml version="1.0"?>

<xsl:stylesheet  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
xmlns:rss="http://purl.org/rss/1.0/"
xmlns:dc="http://purl.org/dc/elements/1.1/" version="1.0">

<!-- main page -->
<xsl:template match="/rdf:RDF">
  <html>
  <head>
  <basefont face="Arial" size="2"/>
  </head>
  <body>
  <xsl:apply-templates select="rss:channel" />
  <ul>
  <xsl:apply-templates select="rss:item" />
  </ul>
  </body>
  </html>
</xsl:template>


<!-- channel -->
<xsl:template match="rss:channel">
  <b>
  <a>
  <xsl:attribute name="href"><xsl:value-of select="rss:link"
/></xsl:attribute>
  <xsl:value-of select="rss:title" />
  </a>
  </b>
</xsl:template>

<!-- item -->
<xsl:template match="rss:item">
  <li />
  <a>
  <xsl:attribute name="href"><xsl:value-of select="rss:link"
/></xsl:attribute>
  <xsl:value-of select="rss:title" />
  </a>
  <br />
  <xsl:value-of select="rss:description" />
</xsl:template>

</xsl:stylesheet>