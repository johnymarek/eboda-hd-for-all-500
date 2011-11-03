#!/bin/sh

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
        <title>Daemons Status</title>
        <link>http://localhost:82/cgi-bin/DaemonsStatus-rss.cgi</link>
        <menu>control panel daemons status</menu>
EOF

name_thttpd="HTTP: thttpd webserver"
name_apache="HTTP: Apache webserver"
name_mediatomb="UPNP/DLNA: Mediatomb"
name_ushare="UPNP/DLNA: Ushare"
name_transmission="TORRENT: Transmission"
name_rtorrent="TORRENT: rtorrent"
name_btpd="TORRENT: btpd"
name_btpd15="TORRENT: btpd 0.15"
name_smbd="NAS: Samba"
name_bftpd="NAS: bftpd"
name_DvdPlayer="CORE: DvdPlayer"

for i in mediatomb ushare btpd15 transmission rtorrent bftpd btpd smbd
do
    script=util_${i}-stop-rss.cgi
    state=Started
    action=Stop
    process=$i
    [ $process == "transmission" ] && process=transmission-daemon
    pidof ${process} >/dev/null
    if [ $? -ne 0 ]
    then
    	script=util_${i}-start-rss.cgi
    	state=Stopped
	action=Start
    fi
    
    full_name=`eval echo \\$name_${i}`
cat <<EOF
        <item>
             <title>${full_name} is $state. Presss OK to $action </title>
             <link>http://localhost:82/cgi-bin/${script}</link>
        </item>
EOF
done


cat <<EOF

</channel>
</rss>
EOF