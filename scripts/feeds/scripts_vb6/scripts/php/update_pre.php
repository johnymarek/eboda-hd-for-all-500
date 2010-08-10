<?php
$html = file_get_contents("http://hdforall.googlecode.com/files/version.txt");
echo "<?xml version='1.0' ?>";
?>
<!--mime-type=  text/plain because acryan feeds are not proper xml-->
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

	<mediaDisplay name="threePartsView" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="40" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="40" idleImageYPC="40" idleImageWidthPC="20" idleImageHeightPC="26">
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		Actualizare HDD Links
		</text>	
		<text offsetXPC=5 offsetYPC=20 widthPC=90 heightPC=8 fontSize=16 backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
<?php echo $html; ?>
		</text>
	</mediaDisplay>
<channel>
<title>Actualizare HDD Links</title>

<item>
<title>Actualizeaza HDD Links acum</title>
<link>http://ims.hdplayers.net/scripts/php/update.php</link>
<media:thumbnail url="http://ims.hdplayers.net/scripts/image/system.png"/>
</item>

</channel>
</rss>
