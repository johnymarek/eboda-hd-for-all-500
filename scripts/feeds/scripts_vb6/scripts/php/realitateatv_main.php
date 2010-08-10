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
		RealitateaTV
		</text>			
</mediaDisplay>

<channel>
	<title>Realitatea TV</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$html = file_get_contents("http://webtv.realitatea.net/");

$html = str_between($html,'<div id="ve_listing_categories">','</ul>');
//$videos = explode('class="noborder" style="width: 50%;">', $html);
$img = "http://ims.hdplayers.net/scripts/image/realitateatv.gif";
$videos = explode('<li', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[2]);
    $link = "http://webtv.realitatea.net".$t2[0];

    $t3 = explode('">', $t1[2]);
    $t4 = explode('<', $t3[1]);
    $title = trim($t4[0]);

		$link1 = "http://ims.hdplayers.net/scripts/php/realitateatv.php?file=".$link;
    echo '<item>';
    print "\n";
    echo '<title>'.$title.'</title>';
    print "\n";
    echo '<link>'.$link1.'</link>';
    print "\n";
    echo '<media:thumbnail url="'.$img.'" />';
    print "\n";
    print '</item>';
		print "\n";
		print "\n";
		
//		$html = file_get_contents($link);
//		$html = str_between($html,'<div id="ve_listing_playlists">','</div>');
		
//		$vids = explode('<a', $html);
//		unset($vids[0]);
//		$vids = array_values($vids);
//		foreach($vids as $vid) {
//			    $t1 = explode('href="', $vid);
//    			$t2 = explode('"', $t1[1]);
//    			$link = "http://webtv.realitatea.net".$t2[0];
//    			if (stripos($link,"rss")=== false) {
//    				$t3 = explode('">', $t1[1]);
//    				$t4 = explode('<', $t3[1]);
//    				$title = trim($t4[0]); 
//    				$link1 = "http://ims.hdplayers.net/scripts/php/realitateatv.php?file=".$link;
//    				echo '<item>';
//    				print "\n";
//    				echo '<title>'.$title.'</title>';
//    				print "\n";
//    				echo '<link>'.$link1.'</link>';
//    				print "\n";
//    				echo '<media:thumbnail url="'.$img.'" />';
//    				print "\n";
//    				print '</item>';
//						print "\n";
//						print "\n";  
//					}
//		}				
}

?>

</channel>
</rss>