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
		Sport.ro
		</text>			
</mediaDisplay>
<channel>
<title>Emisiuni Sport.ro</title>


<item>
<title>Sport.ro - Stiri</title>
<link><?php echo $host; ?>/scripts/tv/sport/sport_ro.php?query=1,http://www.sport.ro/video/stiri/</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/sport_ro.gif" />
</item>

<item>
<title>Sport.ro - Fotbal Extern</title>
<link><?php echo $host; ?>/scripts/tv/sport/sport_ro.php?query=1,http://www.sport.ro/video/fotbal-extern/</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/sport_ro.gif" />
</item>

<item>
<title>Sport.ro - Fotbal Intern</title>
<link><?php echo $host; ?>/scripts/tv/sport/sport_ro.php?query=1,http://www.sport.ro/video/fotbal-intern/</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/sport_ro.gif" />
</item>

<item>
<title>Sport.ro - Nationala</title>
<link><?php echo $host; ?>/scripts/tv/sport/sport_ro.php?query=1,http://www.sport.ro/video/nationala/</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/sport_ro.gif" />
</item>

<item>
<title>Sport.ro - Sporturi</title>
<link><?php echo $host; ?>/scripts/tv/sport/sport_ro.php?query=1,http://www.sport.ro/video/sporturi/</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/sport_ro.gif" />
</item>

<item>
<title>Sport.ro - Show</title>
<link><?php echo $host; ?>/scripts/tv/sport/sport_ro.php?query=1,http://www.sport.ro/video/show/</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/sport_ro.gif" />
</item>

<item>
<title>Sport.ro - ProMotor</title>
<link><?php echo $host; ?>/scripts/tv/sport/sport_ro.php?query=1,http://www.sport.ro/video/promotor/</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/sport_ro.gif" />
</item>

<item>
<title>Sport.ro - Europa League</title>
<link><?php echo $host; ?>/scripts/tv/sport/sport_ro.php?query=1,http://www.sport.ro/video/europa-league/</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/sport_ro.gif" />
</item>


</channel>
</rss>