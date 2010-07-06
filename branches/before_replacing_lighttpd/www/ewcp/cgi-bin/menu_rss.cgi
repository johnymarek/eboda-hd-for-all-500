#!/bin/sh

cat <<EOF
<?xml version='1.0' ?>
<!--mime-type=  text/plain because acryan feeds are not proper xml-->
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<onEnter>
EOF

name_lighttpd="HTTP: Lighttpd webserver"
name_apache="HTTP: Apache webserver"
name_transmission="TORRENT: Transmission"
name_rtorrent="TORRENT: rtorrent"
name_btpd="TORRENT: btpd"
name_smbd="NAS: Samba"
name_bftpd="NAS: bftpd"


for i in lighttpd rtorrent btpd smbd bftpd 
do
    process=$i
    state=Running
    if [ $? -ne 0 ]
    then
    	state=Stopped
    fi
cat <<EOF
     serv_status_$i = "$state";
EOF
done

cat <<EOF
<mediaDisplay name="threePartsView" showDefaultInfo="no" bottomYPC="0" itemGap="0" itemPerPage="12" showHeader="no" sideLeftWidthPC="0" itemImageXPC="0" itemImageHeightPC="0" itemImageWidthPC="0" itemXPC="5" itemYPC="10" itemWidthPC="40" itemHeightPC="8" capWidthPC="45" unFocusFontColor="101:101:101" focusFontColor="255:255:255" 
 idleImageXPC="40" idleImageYPC="40" idleImageWidthPC="20" idleImageHeightPC="26">
       <idleImage> image/POPUP_LOADING_01.jpg </idleImage>
       <idleImage> image/POPUP_LOADING_02.jpg </idleImage>
       <idleImage> image/POPUP_LOADING_03.jpg </idleImage>   
       <idleImage> image/POPUP_LOADING_04.jpg </idleImage>
       <idleImage> image/POPUP_LOADING_05.jpg </idleImage>
       <idleImage> image/POPUP_LOADING_06.jpg </idleImage> 
<backgroundDisplay>
<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>/tmp/hdd/volumes/HDD1/scripts/image/background_720p.jpg</image>
</backgroundDisplay>

<text  offsetXPC=60 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
E-Boda Control Panel
</text>	
EOF


for i in lighttpd rtorrent btpd smbd bftpd 
do
    full_name=`eval echo \\$name_${i}`

cat <<EOF
	<text offsetXPC=45 offsetYPC=18 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	 $full_name Status:
	</text>
	 <text offsetXPC=60 offsetYPC=18 widthPC=90 heightPC=8 fontSize=13 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	  <script>
	  serv_status_$i;
	  </script>
	 </text>

EOF
done


cat <<EOF
</mediaDisplay>

<channel>
<title>Control Panel</title>

<item>
<title>Go Home</title>
<link>/tmp/hdd/volumes/HDD1/scripts/menu.rss</link>
<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/network_tools.jpg"/>
</item>

EOF

for i in lighttpd rtorrent btpd smbd bftpd 
do
cat <<EOF
<item>
<title>Go Home</title>
<link>/tmp/hdd/volumes/HDD1/scripts/menu.rss</link>
<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/network_tools.jpg"/>
</item>


EOF
done

cat <<EOF

</channel>
</rss>
EOF