#!/bin/sh

#begin of old stuff
vb6_rss_start()
{

cat <<EOF
<?xml version="1.0"?>
<!--Xtreamer Community 2010 - xMenu9 Cap-->
<rss version="2.0" xmlns:media="http://purl.org/dc/elements/1.1/" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" showDefaultInfo="no" bottomYPC="0" itemGap="0" itemPerPage="15" showHeader="no" sideLeftWidthPC="0" itemImageXPC="2" itemImageHeightPC="8" itemImageWidthPC="5" itemXPC="8" itemYPC="10" itemWidthPC="50" itemHeightPC="8" capWidthPC="55" unFocusFontColor="101:101:101" focusFontColor="255:255:255" 
idleImageXPC="40" idleImageYPC="40" idleImageWidthPC="20" idleImageHeightPC="26">
        <idleImage>/scripts/scripts9/image/busy1.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy2.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy3.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy4.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy5.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy6.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy7.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy8.png</idleImage>
<backgroundDisplay>
<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>/scripts/image/background_main.jpg</image>
</backgroundDisplay>
</mediaDisplay>
  <channel>
    <title>HDD Links</title>

EOF

}

vb6_rss_exit()
{
cat <<EOF
  </channel>
</rss>

EOF

}

vb6_rss_item()
{
    title = $1;
    link = $2;
    thumbnail = $3;
    text = $4;

cat <<EOF
 

<item>
<title>$title</title>
<link>$link</link>
<media:thumbnail url="$thumbnail"/>
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="10" idleImageHeightPC="16">
		<idleImage> image/POPUP_LOADING_01.jpg </idleImage>
		<idleImage> image/POPUP_LOADING_02.jpg </idleImage>
		<idleImage> image/POPUP_LOADING_03.jpg </idleImage>
		<idleImage> image/POPUP_LOADING_04.jpg </idleImage>
		<idleImage> image/POPUP_LOADING_05.jpg </idleImage>
		<idleImage> image/POPUP_LOADING_06.jpg </idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
                $text
		</text>			
	    </mediaDisplay>
</item>
EOF
}

#end of old stuff