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
        <title>Control Panel</title>
        <link>http://localhost:82/cgi-bin/ewcp-rss.cgi</link>
        <menu>control panel main menu</menu>

<item>
<title>Daemons status</title>
<link>http://localhost:82/cgi-bin/DaemonsStatus-rss.cgi</link>
</item>

<item>
<title>Utilities</title>
<link>http://localhost:82/cgi-bin/Utilities-rss.cgi</link>
</item>


<item>
<title>Updates</title>
<link>http://localhost:82/cgi-bin/Updates-rss.cgi</link>
</item>

<item>
<title>Services</title>
<link>http://localhost:82/cgi-bin/Services-rss.cgi</link>
</item>

</channel>
</rss>
EOF