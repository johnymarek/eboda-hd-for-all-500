#!/bin/sh
d=`date`

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
        <title>Services</title>
        <link>http://localhost:82/cgi-bin/Services-rss.cgi</link>
        <menu>control panel utilities</menu>
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

startfile_dir="/cb3pp/etc/init.d/"

startfile_thttpd="S80thttpd"
startfile_apache="S08apache"
startfile_transmission="S90transmission-daemon"
startfile_mediatomb="S95mediatomb"
startfile_ushare="S95ushare"
startfile_rtorrent="S90rtorrent"
startfile_btpd15="S90btpd15"
startfile_bftpd="S70bftpd"

startfile_btpd="/tmp/package/script/btpd"
startfile_smbd="/tmp/package/script/samba"

for i in mediatomb ushare btpd15 transmission rtorrent bftpd
do
    full_name=`eval echo \\$name_${i}`
    script="#"
    state="Not installed"
    action="N/A"
    
    startfile=`eval echo \\$startfile_${i}`
    if [ -f ${startfile_dir}/$startfile ]
    then
    	script=util_${i}-disable-rss.cgi
    	state="Enabled"
    	action=Disable
    fi
    if [ -f ${startfile_dir}/off.$startfile ]
    then
    	script=util_${i}-enable-rss.cgi
    	state="Disabled"
    	action=Enable
	
    fi

    cat <<EOF
        <item>
             <pubDate>${d}</pubDate>
             <title>${full_name} is $state</title>
             <link>http://localhost:82/cgi-bin/${script}</link>
             <description> Press Right Arrow to $action </description>
        </item>
EOF
done

for i in btpd smbd
do
    full_name=`eval echo \\$name_${i}`
    script="#"
    state="Not installed"
    action="N/A"

    startfile=`eval echo \\$startfile_${i}`


    if [ -f $startfile ] 
    then
    	if [ -x $startfile ]
    	then
    	    script=util_${i}-disable.cgi
    	    state="Enabled"
    	    action=Disable
    	else
    	    script=util_${i}-enable.cgi
    	    state="Disabled"
    	    action=Enable
    	fi
    fi
    
    cat <<EOF
        <item>
             <pubDate>${d}</pubDate>
             <title>${full_name} is $state. Press OK to $action </title>
             <link>http://localhost:82/cgi-bin/${script}</link>
        </item>
EOF
done


cat <<EOF
    </channel>
</rss>

EOF