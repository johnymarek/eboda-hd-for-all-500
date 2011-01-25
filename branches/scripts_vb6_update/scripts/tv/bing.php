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
		Bing
		</text>			
</mediaDisplay>
<channel>
<title>Bing</title>


<item>
<title>******** Sport **********</title>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/bing.jpg" />
</item>

<item>
<title>FOX Soccer Channel</title>
<link><?php echo $host; ?>/scripts/tv/php/bing1.php</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/bing.jpg" />
</item>

<item>
<title>NBA</title>
<link><?php echo $host; ?>/scripts/tv/php/bing.php?file=http://www.bing.com/videos/browse/sports/nba?q=browse:sports/nba</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/bing.jpg" />
</item>

<item>
<title>MLB</title>
<link><?php echo $host; ?>/scripts/tv/php/bing.php?file=http://www.bing.com/videos/browse/sports/mlb?q=browse:sports/mlb</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/bing.jpg" />
</item>

<item>
<title>NHL</title>
<link><?php echo $host; ?>/scripts/tv/php/bing.php?file=http://www.bing.com/videos/browse/sports/nhl?q=browse:sports/nhl</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/bing.jpg" />
</item>

<item>
<title>NFL</title>
<link><?php echo $host; ?>/scripts/tv/php/bing.php?file=http://www.bing.com/videos/browse/sports/nfl?q=browse:sports/nfl</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/bing.jpg" />
</item>

<item>
<title>College Football</title>
<link><?php echo $host; ?>/scripts/tv/php/bing.php?file=http://www.bing.com/videos/browse/sports/college-football?q=browse:sports/college-football</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/bing.jpg" />
</item>

<item>
<title>
College Basketball</title>
<link><?php echo $host; ?>/scripts/tv/php/bing.php?file=http://www.bing.com/videos/browse/sports/college-basketball?q=browse:sports/college-basketball</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/bing.jpg" />
</item>

<item>
<title>******** Comedy **********</title>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/bing.jpg" />
</item>

<item>
<title>The Daily Bubble</title>
<link><?php echo $host; ?>/scripts/tv/php/bing2.php</link>
<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/tv/image/bing.jpg" />
</item>

</channel>
</rss>