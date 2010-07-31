<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<mediaDisplay name="threePartsView" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="20" idleImageHeightPC="26">
	<idleImage>/scripts/image/busy1.png</idleImage>
	<idleImage>/scripts/image/busy2.png</idleImage>
	<idleImage>/scripts/image/busy3.png</idleImage>     
	<idleImage>/scripts/image/busy4.png</idleImage>
	<idleImage>/scripts/image/busy5.png</idleImage>
	<idleImage>/scripts/image/busy06.jpg</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		Posturi radio Romania
		</text>	
	</mediaDisplay>
<channel>
	<title>Posturi Radio Romania</title>
	<menu>main menu</menu>
	<?php
	$html = file_get_contents("http://www.shoutcast.com/sbin/newxml.phtml?search=romania");
	$videos = explode('<station n', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('ame="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];
    $t1 = explode('id="', $video);
    $t2 = explode('"', $t1[1]);
    $id = $t2[0];
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>http://127.0.0.1:82/scripts/php/radio_rom_link.php?id='.$id.'</link>';
    echo '<media:thumbnail url="/scripts/image/shoutcast.png" />';	
    echo '</item>';
    print "\n";
  }
?>
	</channel>
	</rss>