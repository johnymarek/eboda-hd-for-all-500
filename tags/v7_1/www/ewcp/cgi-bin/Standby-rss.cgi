#!/bin/sh

cat <<EOF
Content-type: application/xhtml+xml

<?xml version="1.0" ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
    <channel>
        <title>Standby</title>
        <link>http://localhost:82/cgi-bin/Standby-rss.cgi</link>
        <menu>Standby</menu>
EOF

TO_WAIT=-1
[ -f /tmp/standby_status ] && . /tmp/standby_status
if [ ${TO_WAIT} -gt -1 ]
then

	cat <<EOF
        <item>
             <pubDate>${d}</pubDate>
             <title>Timer is active</title>
             <link>http://localhost:82/cgi-bin/util_standby-cancel-rss.cgi</link>
             <description>
Standby in ${TO_WAIT} minutes.
Press Right Arrow to cancel timer.
</description>
        </item>

EOF
else
    
    for i in 30 60 90 120
    do
	script=util_standby-${i}-rss.cgi
	full_name="Standby in ${i} minutes"
	
	d=`date`
	
	cat <<EOF
        <item>
             <pubDate>${d}</pubDate>
             <title>${full_name}</title>
             <link>http://localhost:82/cgi-bin/${script}</link>
             <description>
Press Right Arrow to activate timer.
</description>
        </item>

EOF
    done
fi
cat <<EOF
    </channel>
</rss>

EOF
