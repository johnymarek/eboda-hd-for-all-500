#!/bin/sh


. ./common.sh

cat <<EOF
Content-type: application/xhtml+xml

<?xml version="1.0" ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
    <channel>
        <title>Updates</title>
        <link>http://localhost:82/cgi-bin/Updates-rss.cgi</link>
        <menu>Updates</menu>
EOF

name_ewcp="WWW: Eboda Web Control Panel"
name_vb6="RSS: vb6rocod php scripts"
name_rssEx="RSS: rssEx (aka media translate)"
name_xLive="RSS: Xtreamer Live"
name_xVoD="RSS: Xtreamer Video on Demand"
name_apps="APPS: extra apps"

component_ewcp="ewcp4"
component_apps="cb3pp4"
component_vb6="scripts4"
component_rssEx="rss_ex4"
component_xLive="xLive4"
component_xVoD="xVoD4"

for i in ewcp apps vb6 rssEx xLive xVoD
do
    script=util_${i}-update-rss.cgi
    full_name=`eval echo \\$name_${i}`
    component=`eval echo \\$component_${i}`

    . /usr/local/etc/storage
    
    if [ ! -d $storage ]
    then 
	echo Cannot find storage $storage. Exiting
	mount
#	nice_exit 1 1
    fi
    
    
    cd $storage
    
    VERSION=0
    [ -f ${storage}/${component}-version.txt ] && . ${storage}/${component}-version.txt
    DISK_VERSION=${VERSION}
    
    ${quietwget} ${masterhost_url}/${component}-version.txt -O ${component}-version-new.txt
    $sync
#    [ $? == 0 ] || nice_exit 1 1
    
    [ -f ./${component}-version-new.txt ] && . ./${component}-version-new.txt
    
    d=`date`

    cat <<EOF
        <item>
             <pubDate>${d}</pubDate>
             <title>Update ${full_name}</title>
             <link>http://localhost:82/cgi-bin/${script}</link>
             <description>

You have version ${DISK_VERSION}, latest available version is ${VERSION}.
EOF
    if [ ${DISK_VERSION} != ${VERSION} ]
then
cat <<EOF

Press Right Arrow to perform the update. Be patient, update can take long (sometimes more than 5 minutes) depending of your network speed and package size. Graphical Interface may restart after update (this mai also take 1 minute).
EOF
fi

cat <<EOF
</description>
        </item>

EOF
done

cat <<EOF
    </channel>
</rss>

EOF
