﻿<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="20" idleImageHeightPC="26">
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
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		Dump.ro
		</text>			
</mediaDisplay>
<channel>
<title>dump.ro</title>


<item>
<title>Video noi</title>
<link><?php echo $host; ?>/scripts/clip/php/dump.php?query=,http://www.dump.ro/videoclipuri</link>
<media:thumbnail url="/scripts/clip/image/dump.jpg" />
</item>

<item>
<title>Filmulete</title>
<link><?php echo $host; ?>/scripts/clip/php/dump.php?query=,http://www.dump.ro/videoclipuri/filmulete</link>
<media:thumbnail url="/scripts/clip/image/dump.jpg" />
</item>

<item>
<title>Filmulete haioase</title>
<link><?php echo $host; ?>/scripts/clip/php/dump.php?query=,http://www.dump.ro/videoclipuri/filmulete-haioase</link>
<media:thumbnail url="/scripts/clip/image/dump.jpg" />
</item>

<item>
<title>Videoclipuri</title>
<link><?php echo $host; ?>/scripts/clip/php/dump.php?query=,http://www.dump.ro/videoclipuri/videoclipuri</link>
<media:thumbnail url="/scripts/clip/image/dump.jpg" />
</item>

<item>
<title>Videoclipuri 2010</title>
<link><?php echo $host; ?>/scripts/clip/php/dump.php?query=,http://www.dump.ro/videoclipuri/videoclipuri-2010</link>
<media:thumbnail url="/scripts/clip/image/dump.jpg" />
</item>

<item>
<title>Videoclipuri romanesti</title>
<link><?php echo $host; ?>/scripts/clip/php/dump.php?query=,http://www.dump.ro/videoclipuri/videoclipuri-romanesti</link>
<media:thumbnail url="/scripts/clip/image/dump.jpg" />
</item>

<item>
<title>Desene animate</title>
<link><?php echo $host; ?>/scripts/clip/php/dump.php?query=,http://www.dump.ro/videoclipuri/desene-animate</link>
<media:thumbnail url="/scripts/clip/image/dump.jpg" />
</item>

<item>
<title>Top video</title>
<link><?php echo $host; ?>/scripts/clip/php/dump.php?query=,http://www.dump.ro/videoclipuri/top-video</link>
<media:thumbnail url="/scripts/clip/image/dump.jpg" />
</item>

</channel>
</rss>