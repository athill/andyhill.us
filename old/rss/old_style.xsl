<?xml version="1.0"?>

<xsl:stylesheet  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
xmlns:rss="http://purl.org/rss/1.0/"
xmlns:dc="http://purl.org/dc/elements/1.1/" version="1.0">

<!-- main page -->
<xsl:template match="/">
  <html>
  <head>
  <basefont face="Arial" size="2"/>
  </head>
  <body>
  <xsl:apply-templates select="//channel" />
  <ul>
  <xsl:apply-templates select="//item" />
  </ul>
  </body>
  </html>
</xsl:template>


<!-- channel -->
<xsl:template match="channel">
  <strong>
  <a>
  <xsl:attribute name="href"><xsl:value-of select="link"
/></xsl:attribute>
  <xsl:value-of select="title" />
  </a>
  </strong>
</xsl:template>

<!-- item -->
<xsl:template match="item">
  <li />
  <a>
  <xsl:attribute name="href"><xsl:value-of select="link"
/></xsl:attribute>
  <xsl:value-of select="title" />
  </a>
  <br />
  <xsl:value-of select="description" />
</xsl:template>

</xsl:stylesheet>