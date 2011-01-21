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
             <title>Standby function</title>
             <link>http://localhost/cgi-bin/Standby-rss.cgi</link>
             <description>Standby function</description>
             <canEnterItem>false</canEnterItem>
        </item>
    </channel>
</rss>

EOF
