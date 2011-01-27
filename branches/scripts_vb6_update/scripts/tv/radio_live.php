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
		Posturi radio
		</text>		
</mediaDisplay>
  <channel>

    <title>Posturi Radio</title>

<item>
<title>radioio</title>
<link><?php echo $host; ?>/scripts/tv/radioio.php</link>
<media:thumbnail url="/scripts/tv/image/radioio/radioio_logo.jpg" />
<mediaDisplay name="photoView"/>
</item>
<item>
<title>nullwave.ru</title>
<link><?php echo $host; ?>/scripts/tv/nullwave.rss</link>
<media:thumbnail url="/scripts//scripts/image/internetradio.png" />
<mediaDisplay name="threePartsView"/>
</item>
<item>
<title>Radio Prahova</title>
<link><?php echo $host; ?>/scripts/tv/rph.rss</link>
<media:thumbnail url="/scripts/tv/image/rph.png" />
<mediaDisplay name="threePartsView"/>
</item>

<item>
<title>Radio România</title>
<link><?php echo $host; ?>/scripts/tv/radio_romania.php</link>
<media:thumbnail url="/scripts/tv/image/radio_romania.jpg" />
<mediaDisplay name="threePartsView"/>
</item>

</channel>
</rss>                                                                                                                             