<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  exclude-result-prefixes=""
>

<xsl:output method="xml" encoding="utf-8" indent="yes"/>

<xsl:param name="name" value="''" />

<xsl:template match="/">
  <xsl:apply-templates select="//div[@class='r_bl']"/>
</xsl:template>

<xsl:template match="div">
  <track>
	<location>http://station.ru/<xsl:value-of select="p/a/@href"/></location>
  	<title><xsl:value-of select=".//h3[@class='h3red left']/a"/></title>
  	<annotation><xsl:value-of select=".//p[@class='small gray1']"/></annotation>
  	<image><xsl:value-of select="p/a/img/@src"/></image>
  </track>
</xsl:template>

<xsl:template match="* | @* | node()"/>

</xsl:stylesheet>