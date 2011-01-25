#!/usr/local/bin/Resource/www/cgi-bin/php
﻿<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1/cgi-bin";
?>
<rss version="2.0" xmlns:media="http://purl.org/dc/elements/1.1/" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="20" idleImageHeightPC="26">
	<idleImage>image/busy1.png</idleImage>
	<idleImage>image/busy2.png</idleImage>
	<idleImage>image/busy3.png</idleImage>
	<idleImage>image/busy4.png</idleImage>
	<idleImage>image/busy5.png</idleImage>
	<idleImage>image/busy6.png</idleImage>
	<idleImage>image/busy7.png</idleImage>
	<idleImage>image/busy8.png</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		Posturi TV locale
		</text>			
</mediaDisplay>
  <channel>

    <title>Emisiuni posturi locale</title>

<item>
<title>Emisiuni tvt89</title>
<link><?php echo $host; ?>/scripts/tv/locale/tvt89.php</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/tvt89.jpg" />
</item>

<item>
<title>1tvbacau.ro</title>
<link><?php echo $host; ?>/scripts/tv/locale/1tvbacau.php</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/1tvbacau.jpg" />
</item>

<item>
<title>ctvmedia (Constanta)</title>
<link><?php echo $host; ?>/scripts/tv/locale/ctvmedia.php</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/ctvmedia.jpg" />
</item>

<item>
<title>TVSat (Buzau)</title>
<link><?php echo $host; ?>/scripts/tv/locale/tvsatrm.php</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/tvsat.gif" />
</item>

<item>
<title>InfoTV (Arad)</title>
<link><?php echo $host; ?>/scripts/tv/locale/infotv.php</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/infotv.gif" />
</item>

<item>
<title>RadioTeleviziunea Severin</title>
<link><?php echo $host; ?>/scripts/tv/locale/televiziuneaseverin.php</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/televiziuneaseverin.png" />
</item>

<item>
<title>TeleM (Iasi)</title>
<link><?php echo $host; ?>/scripts/tv/locale/telem_main.php</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/telem.png" />
</item>

<item>
<title>TV Bacau</title>
<link><?php echo $host; ?>/scripts/tv/locale/tvbacau.php</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/tvbacau.gif" />
</item>

</channel>
</rss>