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
		prohovaHD
		</text>			
</mediaDisplay>
<channel>
	<title>prahovahd.ro</title>
	<menu>main menu</menu>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
//rtmp://193.238.56.74/vod/mp4:notredame.mp4
$html = file_get_contents("http://live.prahovahd.ro/playlist.php");
$videos = explode('<track>', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $link = "http://127.0.0.1/cgi-bin/rtmp?rtmp://193.238.56.74/vod/mp4:".str_between($video,"<location>","</location>");
		$title = str_between($video,"<title>","</title>");
    
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="http://ims.hdplayers.net/scripts/image/tv_radio.png" />';
    echo '<enclosure type="video/mp4" url="'.$link.'"/>';	
    echo '</item>';
}
?>
</channel>
</rss>