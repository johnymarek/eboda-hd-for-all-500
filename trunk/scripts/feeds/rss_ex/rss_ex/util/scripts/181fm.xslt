<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:param name="name" value="''" />

<xsl:template match="/">
<playlist version="1" xmlns="http://xspf.org/ns/0/">
<title>181.FM</title>
<trackList>
  <xsl:apply-templates select="//table/tr[count(td)=3 and td[2]/a='128k']"/>
</trackList>
</playlist>

</xsl:template>

<xsl:template match="tr">
  <track>
	<location><xsl:value-of select="td[2]/a/@href"/></location>
  	<title><xsl:value-of select="normalize-space(td[1])"/></title>
  </track>
</xsl:template>

<xsl:template match="* | @* | node()"/>

</xsl:stylesheet>