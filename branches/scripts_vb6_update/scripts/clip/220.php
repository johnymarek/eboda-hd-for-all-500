<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
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
		220.ro
		</text>			
</mediaDisplay>
<channel>
<title>220.ro</title>
<link>/220.rss</link>

<item>
<title>Search</title>
<link>rss_command://search</link>
<search url="<?php echo $host; ?>/scripts/clip/php/220_search.php?query=1,%s" />
<media:thumbnail url="/scripts/image/search.png" />
</item>


<item>
<title>200.ro - Shows</title>
<link><?php echo $host; ?>/scripts/clip/php/220_show_main.php</link>
</item>

<item>
<title>200.ro - selectii</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/</link>
</item>

<item>
<title>200.ro - filmele zilei</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/filmele-zilei/</link>
</item>

<item>
<title>200.ro - Cele mai recente</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/cele-mai-noi/</link>
</item>

<item>
<title>200.ro - Cele mai vizionate</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/cele-mai-vazute/</link>
</item>

<item>
<title>200.ro - Cele mai comentate</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/cele-mai-comentate/</link>
</item>

<item>
<title>Toate filmele</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/video/</link>
</item>

<item>
<title>Animale</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/animale/</link>
</item>

<item>
<title>Auto, moto</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/auto/</link>
</item>

<item>
<title>Cinema, movie trailers</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/trailer/</link>
</item>

<item>
<title>Comedie, Umor romanesc</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/umor-romanesc/</link>
</item>

<item>
<title>Desene animate</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/desene-animate/</link>
</item>

<item>
<title>Emisiuni TV</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/emisiuni-tv/</link>
</item>

<item>
<title>Farse</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/farse/</link>
</item>

<item>
<title>Faze tari</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/faze-tari/</link>
</item>

<item>
<title>Funny</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/funny/</link>
</item>

<item>
<title>Interzis la birou</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/sexy/</link>
</item>

<item>
<title>Jocuri, Gameplay</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/gaming/</link>
</item>

<item>
<title>Muzica, Videoclipuri</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/videoclipuri/</link>
</item>

<item>
<title>Prieteni, petreceri, clubbing</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/party/</link>
</item>

<item>
<title>Reclame</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/reclame/</link>
</item>

<item>
<title>Sport</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/sport/</link>
</item>

<item>
<title>Vedete</title>
<link><?php echo $host; ?>/scripts/clip/php/220.php?query=,http://www.220.ro/vedete/</link>
</item>


</channel>
</rss>