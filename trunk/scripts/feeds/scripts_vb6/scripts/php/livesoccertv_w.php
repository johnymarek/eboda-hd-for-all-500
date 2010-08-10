<?php echo "<?xml version='1.0' ?>"; ?>
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
		livesoccertv.com
		</text>			
</mediaDisplay>
<channel>
	<title>World Cup Matches</title>
	<menu>main menu</menu>



<?php
$html = file_get_contents("http://www.livesoccertv.com/world-cup-2010/#_videos");
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$html = str_between($html,'<th width="15%">Stage</th>','</table>');
$image = "http://ims.hdplayers.net/scripts/image/livesoccertv.gif";
$videos = explode('<tr', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[3]);
		$link = "http://www.livesoccertv.com".$t2[0];
		if (strpos($link, "/match") === false) {
			$t2 = explode('"', $t1[2]);
		}
		$link = "http://www.livesoccertv.com".$t2[0];
		$link = "http://ims.hdplayers.net/scripts/php/livesoccertv_link.php?file=".$link;
		
//    	$t1 = explode('src="', $video);
//    	$t2 = explode('"', $t1[1]);
//    	$image = "http://www.uefa.com".$t2[0];

    	$t1 = explode('title="', $video);
    	$t2 = explode('-', $t1[4]);
    	$title1 = trim($t2[0]);
    	$title2 = str_between($video,"<b>","</b>");
    	$title = $title1." *** ".$title2;

    	$t3 = explode('FIFA World Cup -', $t1[4]);
    	$t4 = explode('"', $t3[1]);
    	$data = trim($t4[0]);
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<pubDate>'.$data.'</pubDate>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
//    	echo '<enclosure type="video/flv" url="'.$link.'"/>';    		
    	echo '</item>';
    	print "\n";

}


?>

</channel>
</rss>