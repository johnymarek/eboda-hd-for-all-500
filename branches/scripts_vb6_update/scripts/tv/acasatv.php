#!/usr/local/bin/Resource/www/cgi-bin/php
﻿<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1/cgi-bin";
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
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
		Acasa TV
		</text>			
</mediaDisplay>
<channel>
<title>Emisiuni Acasa TV</title>


<item>
<title>AcasaTV - Povestiri Adevarate</title>
<link><?php echo $host; ?>/scripts/tv/php/acasatv-povestiri-adevarate.php?query=1,</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/acasatv-povestiri-adevarate.jpg" />
</item>

<item>
<title>AcasaTV - Povestiri De Noapte</title>
<link><?php echo $host; ?>/scripts/tv/php/acasatv-povestiri-de-noapte.php?query=1,</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/acasatv-povestiri-de-noapte.jpg" />
</item>

<item>
<title>AcasaTV - La naiba sa povestim</title>
<link><?php echo $host; ?>/scripts/tv/php/acasatv-la-naiba-sa-povestim.php?query=1,</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/acasatv-la-naiba-sa-povestim.jpg" />
</item>

</channel>
</rss>