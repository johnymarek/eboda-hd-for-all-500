#!/usr/local/bin/Resource/www/cgi-bin/php
﻿<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
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
		RTS Severin
		</text>			
</mediaDisplay>
<channel>
	<title>RTS Severin</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}

$html = file_get_contents("http://gdata.youtube.com/feeds/api/users/rtseverin/uploads");
$videos = explode('<entry>', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
$id = str_between($video,"<id>http://gdata.youtube.com/feeds/api/videos/","</id>");
$title = str_between($video,"<title type='text'>","</title>");
$data = str_between($video,"<updated>","</updated>");
$image = "http://i.ytimg.com/vi/".$id."/2.jpg";
$link = "http://127.0.0.1/cgi-bin/translate?stream,HD:1,http://www.youtube.com/watch?v=".$id;
echo '<item>';
echo '<title>'.$title.'</title>';
echo '<link>'.$link.'</link>';
echo '<pubDate>'.$data.'</pubDate>';
echo '<media:thumbnail url="'.$image.'" />';
echo '<enclosure type="video/flv" url="'.$link.'"/>';
echo '</item>';
print "\n";
}
?>
</channel>
</rss>