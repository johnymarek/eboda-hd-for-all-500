<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

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
    $link = "http://127.0.0.1:82/cgi-bin/rtmp?rtmp://193.238.56.74/vod/mp4:".str_between($video,"<location>","</location>");
		$title = str_between($video,"<title>","</title>");
    
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="/scripts/image/tv_radio.png" />';
    echo '<enclosure type="video/mp4" url="'.$link.'"/>';	
    echo '</item>';
}
?>
</channel>
</rss>