<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>livesoccertv_link</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];
$suf1 = "/vid.mp4";
$suf2 = "/vid.flv";

$html = file_get_contents($link);
$videos = explode('<div id="video">', $html);

unset($videos[0]);
$videos = array_values($videos);
//http://l3-hl1.videos02.myspacecdn.com/videos02/179/695e6c86381c40f8869714355dc6c49a/vid.flv
//http://l3-hl1.videos02.myspacecdn.com/videos02/179/695e6c86381c40f8869714355dc6c49a/vid.flv
foreach($videos as $video) {
	//<embed src="
	  $t1 = explode('<embed src="', $video);
    $t2 = explode('"', $t1[1]);
		$link = $t2[0];
		if (strpos($link, "rd3.videos.sapo") !== false) {
			$t3 = explode('file=',$t2[0]);
			$link=$t3[1];
			echo '<item>';
    	echo '<title>Link - videos.sapo</title>';
    	echo '<link>'.$link.'</link>';
    	echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    	echo '</item>';
		}
		if (strpos($link, "youtube") !== false) {
			$t3 = explode('file=',$t2[0]);
			$v_id=str_between($link,'v/','&');
			$link = "http://127.0.0.1:82/scripts/php/yt.php?id=".$v_id ;
			echo '<item>';
    	echo '<title>Link - youtube</title>';
    	echo '<link>'.$link.'</link>';
    	echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    	echo '</item>';
		}
		$link = str_between($video,'<param name="movie" value="','"');
		if ($link <> "") {
			$m_id = str_between($link,"m=",",");
			$link = "http://vids.myspace.com/index.cfm?fuseaction=vids.individual&videoid=".$m_id;
			$h1 = file_get_contents($link);
			$link = str_between($h1,'<link rel="image_src" href="','"');
			$link = str_replace('thumb1_','',$link);
			$link = str_replace('thumb2_','',$link);
			$link = str_replace('.jpg','',$link);
			$part = substr($link,34);
			$link = "http://l3-hl1.videos02.myspacecdn.com".$part.$suf1; //mp4
			$AgetHeaders = @get_headers($link);
			if (!preg_match("|200|", $AgetHeaders[0])) {
				$link = "http://l3-hl1.videos02.myspacecdn.com".$part.$suf2; //flv	
				$AgetHeaders = @get_headers($link);
				if (!preg_match("|200|", $AgetHeaders[0])) {
					$link = "http://l3-hl1xl.myspacecdn.cust.footprint.net".$part.$suf1; //mp4
					$AgetHeaders = @get_headers($link);
					if (!preg_match("|200|", $AgetHeaders[0])) {
						$link = "http://l3-hl1xl.myspacecdn.cust.footprint.net".$part.$suf2; //flv
						$AgetHeaders = @get_headers($link);
						if (!preg_match("|200|", $AgetHeaders[0])) {
							$link = "";
						}
					}
				}
			}
	if ($link <> "") {
			echo '<item>';
    	echo '<title>Link - myspace</title>';
    	echo '<link>'.$link.'</link>';
    	echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    	echo '</item>';
    	print "\n";
    }
		}

}

?>


</channel>
</rss>