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
		Antena1 - Emisiuni
		</text>			
</mediaDisplay>
  <channel>

    <title>Antena1 - Emisiuni</title>

<item>
<title>In gura presei cu Mircea Badea</title>
<link><?php echo $host; ?>/scripts/tv/php/antena1_igp_emisiuni.php</link>
<media:thumbnail url="/scripts/tv/image/antena1_igp.jpg" />
</item>

<item>
<title>In puii mei cu Mihai Bendeac</title>
<link><?php echo $host; ?>/scripts/tv/php/antena1_ipm_emisiuni.php</link>
<media:thumbnail url="/scripts/tv/image/antena1_ipm.jpg" />
</item>

<item>
<title>Neatza cu Razvan si Dani</title>
<link><?php echo $host; ?>/scripts/tv/php/antena1_neatza_emisiuni.php</link>
<media:thumbnail url="/scripts/tv/image/antena1_neatza.jpg" />
</item>

<item>
<title>Un show pacatos cu Dan Capatos</title>
<link><?php echo $host; ?>/scripts/tv/php/antena1_pacatos_emisiuni.php</link>
<media:thumbnail url="/scripts/tv/image/antena1_pacatos.jpg" />
</item>

<item>
<title>Acces direct cu Madalin Ionescu</title>
<link><?php echo $host; ?>/scripts/tv/php/antena1_acces_emisiuni.php</link>
<media:thumbnail url="/scripts/tv/image/antena1_acces.jpg" />
</item>

</channel>
</rss>