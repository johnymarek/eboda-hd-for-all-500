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

    . /usr/local/etc/storage
    
    if [ ! -d $storage ]
    then 
	echo Cannot find storage $storage. Exiting
	mount
	nice_exit 1
    else
	echo Storage $storage found
    fi
    
    
    cd $storage
    
    VERSION=0
    [ -f ${storage}/${component}-version.txt ] && . ${storage}/${component}-version.txt
    DISK_VERSION=${VERSION}
    
    wget http://eboda-hd-for-all-500.googlecode.com/files/${component}-version.txt -O ${component}-version-new.txt
    [ $? == 0 ] || nice_exit 1  
    
    [ -f ./${component}-version-new.txt ] && . ./${component}-version-new.txt
    
    d=`date`

    cat <<EOF
        <item>
             <pubDate>${d}</pubDate>
             <title>Update ${full_name}</title>
             <link>http://localhost/cgi-bin/${script}</link>
             <description> 
<p> You have version ${DISK_VERSION}, latest available version is ${VERSION}</p>
<p> Press Right Arrow to perform the update </p>
</description>
        </item>
EOF
done

cat <<EOF
    </channel>
</rss>

EOF
