﻿<?php echo "<?xml version='1.0' ?>"; ?>
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
		TeleM - Iasi
		</text>			
</mediaDisplay>

<channel>
	<title>telem</title>
	<menu>main menu</menu>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}

$html = file_get_contents("http://www.telem.ro/telem/");
$html = str_between($html,'<h3>Emisiuni</h3>','</ul>');

$videos = explode('<li', $html);
unset($videos[0]);
$videos = array_values($videos);
$img = "http://ims.hdplayers.net/scripts/image/telem.png";
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link ="http://www.telem.ro".$t2[0];

    $title = str_between($video,'<span>','<');

		$link="http://ims.hdplayers.net/scripts/php/telem.php?query=,".$link;

    echo '<item>';
    print "\n";
    echo '<title>'.$title.'</title>';
    print "\n";
    echo '<link>'.$link.'</link>';
    print "\n";
    echo '<media:thumbnail url="'.$img.'" />';
    print "\n";
    print '</item>';
		print "\n";
		print "\n";
}
?>

</channel>
</rss>