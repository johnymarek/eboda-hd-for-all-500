<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>sportgioco</title>
	<menu>main menu</menu>


<?php

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$html = file_get_contents("http://www.sportgioco.it/calcio/highlights.php");
$image = "/tmp/hdd/volumes/HDD1/scripts/image/sportgioco.jpg";
$videos = explode('<tr>', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
		$link = $t2[0];
		if (strpos($link, "youtube") !== false) {
			if (strpos($link, "&") === false) {
			$v_id = substr(strrchr($link, "="), 1);
			//$link = "http://127.0.0.1:82/scripts/php/yt.php?id=".$v_id ;
			$link = "";
		} else {
			$v_id = str_between($link,'v=','&');
			//$link = "http://127.0.0.1:82/scripts/php/yt.php?id=".$v_id ;
			$link = "";
		}
	}
		if (strpos($link, "sapo.pt") !== false) {
			$v_id = substr(strrchr($link, "/"), 1);
			$link = "http://rd3.videos.sapo.pt/".$v_id."/mov/1" ;
		}
		
    	$title = str_between($video,'target="_blank">','<');

    	$data = str_between($video,'<td class="tdLight3" style="text-align:center" width="15%">','</td>');
		if ($link <> "") {
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<pubDate>'.$data.'</pubDate>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '<enclosure type="video/flv" url="'.$link.'"/>';    		
    	echo '</item>';
    	print "\n";
}
}


?>

</channel>
</rss>