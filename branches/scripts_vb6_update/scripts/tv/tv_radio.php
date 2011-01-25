<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
<rss version="2.0" xmlns:media="http://purl.org/dc/elements/1.1/" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" 
	itemBackgroundColor="0:0:0" 
	backgroundColor="0:0:0" 
	sideLeftWidthPC="0" 
	itemImageXPC="5" 
	itemXPC="20" 
	itemYPC="20" 
	itemWidthPC="65" 
	capWidthPC="70" 
	unFocusFontColor="101:101:101" 
	focusFontColor="255:255:255" 
	popupXPC = "40"
  popupYPC = "55"
  popupWidthPC = "22.3"
  popupHeightPC = "5.5"
  popupFontSize = "13"
	popupBorderColor="28:35:51" 
	popupForegroundColor="255:255:255"
 	popupBackgroundColor="28:35:51"
	idleImageXPC="45" 
	idleImageYPC="42" 
	idleImageWidthPC="20" 
	idleImageHeightPC="26">
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
		TV si Radio
		</text>			
</mediaDisplay>
  <channel>

    <title>TV si Radio</title>

<item>
<title>TV Live</title>
<link><?php echo $host; ?>/scripts/tv/tv_live.php</link>
<media:thumbnail url="/scripts//scripts/image/tv_radio.png" />
</item>

<item>
<title>Emisiuni Antena 1</title>
<link><?php echo $host; ?>/scripts/tv/php/antena1_main.php</link>
<media:thumbnail url="/scripts/tv/image/antena1.jpg" />
</item>

<item>
<title>Emisiuni Antena2</title>
<link><?php echo $host; ?>/scripts/tv/php/antena2_main.php</link>
<media:thumbnail url="/scripts/tv/image/antena2.jpg" />
</item>

<item>
<title>Emisiuni ProTV</title>
<link><?php echo $host; ?>/scripts/tv/php/protv_main.php</link>
<media:thumbnail url="/scripts/tv/image/protv.jpg" />
</item>

<item>
<title>Emisiuni AcasaTV</title>
<link><?php echo $host; ?>/scripts/tv/acasatv.php</link>
<media:thumbnail url="/scripts/tv/image/acasatv.jpg" />
</item>

<item>
<title>Emisiuni EuforiaTV</title>
<link><?php echo $host; ?>/scripts/tv/php/euforiatv.php</link>
<media:thumbnail url="/scripts/tv/image/euforiatv.gif" />
</item>

<item>
<title>Emisiuni RealitateaTV</title>
<link><?php echo $host; ?>/scripts/tv/php/realitateatv_main.php</link>
<media:thumbnail url="/scripts/tv/image/realitateatv.gif" />
</item>

<item>
<title>Emisiuni Money.ro WebTV</title>
<link><?php echo $host; ?>/scripts/tv/php/money.php</link>
<media:thumbnail url="/scripts/tv/image/money.gif" />
</item>

<item>
<title>Emisiuni SensoTV</title>
<link><?php echo $host; ?>/scripts/tv/sensotv.php</link>
<media:thumbnail url="/scripts/tv/image/sensotv.png" />
</item>

<item>
<title>Emisiuni Publika.Md (Rep. Moldova)</title>
<link><?php echo $host; ?>/scripts/tv/php/publika.php</link>
<media:thumbnail url="/scripts/tv/image/publika.jpg" />
</item>

<item>
<title>JurnalTV (Rep. Moldova)</title>
<link><?php echo $host; ?>/scripts/tv/php/jurnaltv_main.php</link>
<media:thumbnail url="/scripts/tv/image/jurnaltv.jpg" />
</item>

<item>
<title>OneHD</title>
<link><?php echo $host; ?>/scripts/tv/prahovahd.php</link>
<media:thumbnail url="/scripts/tv/image/onehd.png" />
</item>

<item>
<title>Emisiuni Sportive</title>
<link><?php echo $host; ?>/scripts/tv/tv_sport.php</link>
<media:thumbnail url="/scripts//scripts/image/tv_radio.png" />
</item>

<item>
<title>Emisiuni TV posturi locale</title>
<link><?php echo $host; ?>/scripts/tv/locale.php</link>
<media:thumbnail url="/scripts//scripts/image/tv_radio.png" />
</item>

<item>
<title>Revision3</title>
<link><?php echo $host; ?>/scripts/tv/rev3.php</link>
<media:thumbnail url="/scripts/tv/image/revision3.gif"  />
</item>

<item>
<title>Bing</title>
<link><?php echo $host; ?>/scripts/tv/bing.php</link>
<media:thumbnail url="/scripts/tv/image/bing.jpg"  />
</item>

<item>
<title>Cronica Carcotasilor KissFM</title>
<link>http://cronica.primatv.ro/podcast/podcast.xml</link>
<media:thumbnail url="/scripts//scripts/image/tv_radio.png" />
</item>

</channel>
</rss>
