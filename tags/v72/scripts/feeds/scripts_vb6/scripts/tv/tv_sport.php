<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
<rss version="2.0" xmlns:media="http://purl.org/dc/elements/1.1/" xmlns:dc="http://purl.org/dc/elements/1.1/">
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
		Emisiuni Sportive
		</text>			
</mediaDisplay>
  <channel>

    <title>Emisiuni Sportive</title>

<item>
<title>Sport.ro - Inregistrari</title>
<link><?php echo $host; ?>/scripts/tv/sport_ro.php</link>
<media:thumbnail url="/scripts/tv/image/sport_ro.gif" />
</item>

<item>
<title>Liga2.ro</title>
<link><?php echo $host; ?>/scripts/tv/sport/liga2.php</link>
<media:thumbnail url="/scripts/tv/image/liga2.gif" />
</item>

<item>
<title>sportgioco.it</title>
<link><?php echo $host; ?>/scripts/tv/sport/sportgioco.php</link>
<media:thumbnail url="/scripts/tv/image/sportgioco.jpg" />
</item>

<item>
<title>DigiSport - youtube</title>
<link><?php echo $host; ?>/scripts/php1/youtube_user.php?query=1,DigiSportTV</link>
<media:thumbnail url="/scripts/image/youtube.gif" />
</item>

<item>
<title>Steaua Bucureşti</title>
<link><?php echo $host; ?>/scripts/tv/sport/steaua.php</link>
<media:thumbnail url="/scripts/tv/image/steaua.png" />
</item>

<item>
<title>Dinamo Bucureşti</title>
<link><?php echo $host; ?>/scripts/tv/sport/dinamo.php</link>
<media:thumbnail url="/scripts/tv/image/dinamo.png" />
</item>

<item>
<title>CFR Cluj</title>
<link><?php echo $host; ?>/scripts/tv/sport/cfr_cluj.php</link>
<media:thumbnail url="/scripts/tv/image/cfr_cluj.png" />
</item>

<item>
<title>sportitalia</title>
<link><?php echo $host; ?>/scripts/tv/sport/sportitalia.php</link>
<media:thumbnail url="/scripts/tv/image/sportitalia.jpg" />
</item>

<item>
<title>Bing</title>
<link><?php echo $host; ?>/scripts/tv/bing_sport.php</link>
<media:thumbnail url="/scripts/tv/image/bing.jpg" />
</item>

<item>
<title>NBA</title>
<link><?php echo $host; ?>/scripts/php1/youtube_user.php?query=1,nba</link>
<media:thumbnail url="/scripts/image/youtube.gif" />
</item>


</channel>
</rss>
