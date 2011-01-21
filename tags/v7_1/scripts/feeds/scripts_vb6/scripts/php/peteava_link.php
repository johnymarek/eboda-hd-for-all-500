<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>peteava.ro</title>
	<menu>main menu</menu>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];
    $html = file_get_contents($link);
    $link = str_between($html, '<div id="player_container_size"><script src="', '"');
    $html = file_get_contents($link);
    $html = str_between($html,'"flashvars"','pluginspage');
    $streamer = str_between($html,'&streamer=','&');
    $id = str_between($html,'id=','&');
    $file = str_between($html,'file=','&');
    $link = $streamer.'?file='.$file.'&start=0&id='.$id.'&client=FLASH%20WIN%2010,0,45,2&version=4.2.95&width=624';
    $link = str_replace('&','&amp;',$link);
    echo '<item>';
    echo '<title>Link</title>';
    echo '<link>'.$link.'</link>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';

?>
</channel>
</rss>