#!/bin/sh

d=`date`

cat <<EOF
Content-type: application/xhtml+xml

<?xml version="1.0" ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
    <channel>
        <title>Utilities</title>
        <link>http://localhost/cgi-bin/Utilities-rss.cgi</link>
        <menu>control panel utilities</menu>

        <item>
             <pubDate>${d}</pubDate>
             <title>Nothing yet</title>
             <link>noLink</link>
             <description> Nothing yet </description>
        </item>

cat <<EOF
    </channel>
</rss>

EOF
