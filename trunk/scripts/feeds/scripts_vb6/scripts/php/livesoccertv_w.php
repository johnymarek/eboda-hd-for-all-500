<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

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
$image = "/scripts/image/livesoccertv.gif";
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
		$link = "http://127.0.0.1:82/scripts/php/livesoccertv_link.php?file=".$link;
		
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