#!/bin/sh


. ./common.sh

cat <<EOF
Content-type: application/xhtml+xml

<?xml version="1.0" ?>
<rss version="2.0" xmlns:media="http://purl.org/dc/elements/1.1/" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10">
        <idleImage>image/POPUP_LOADING_01.png</idleImage>
        <idleImage>image/POPUP_LOADING_02.png</idleImage>
        <idleImage>image/POPUP_LOADING_03.png</idleImage>
        <idleImage>image/POPUP_LOADING_04.png</idleImage>
        <idleImage>image/POPUP_LOADING_05.png</idleImage>
        <idleImage>image/POPUP_LOADING_06.png</idleImage>
        <idleImage>image/POPUP_LOADING_07.png</idleImage>
        <idleImage>image/POPUP_LOADING_08.png</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
</mediaDisplay>
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
             <title>Update ${full_name}. Be patient. </title>
             <link>http://localhost:82/cgi-bin/${script}</link>
        </item>

EOF
done

cat <<EOF
    </channel>
</rss>

EOF
