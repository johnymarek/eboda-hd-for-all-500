<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">


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
$img = "/tmp/hdd/volumes/HDD1/scripts/image/realitateatv.gif";
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

		$link1 = "http://127.0.0.1:82/scripts/php/realitateatv.php?file=".$link;
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
//    				$link1 = "http://127.0.0.1:82/scripts/php/realitateatv.php?file=".$link;
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