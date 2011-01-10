#!/bin/sh

cat <<EOF
Content-type: application/xhtml+xml

<?xml version="1.0" ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
    <channel>
        <title>Updates</title>
        <link>http://localhost/cgi-bin/Updates-rss.cgi</link>
        <menu>Updates</menu>
EOF

name_ewcp="WWW: Eboda Web Control Panel"
name_vb6="RSS: vb6rocod php scripts"
name_rssEx="RSS: rssEx (aka media translate)"
name_xLive="RSS: Xtreamer Live"
name_apps="APPS: extra apps"

for i in ewcp apps vb6 rssEx xLive
do
    script=util_${i}-update-rss.cgi
    full_name=`eval echo \\$name_${i}`
    cat <<EOF
        <item>
             <pubDate>Wed, 05 Jan 2011 22:49:32 +0000</pubDate>
             <title>Update ${full_name}</title>
             <link>http://localhost/cgi-bin/${script}</link>
             <description> Press Right Arrow to perform the update </description>
        </item>
EOF
done

cat <<EOF
    </channel>
</rss>

EOF
