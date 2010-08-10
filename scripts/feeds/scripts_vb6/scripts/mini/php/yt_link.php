<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>youtube</title>
	<menu>main menu</menu>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];
    $html = file_get_contents($link);
		$v_id = str_between($html, "&video_id=", "&");
		$t_id = str_between($html, "&t=", "&");
		$link = "http://127.0.0.1:8080/yt.php?id=".$v_id ;
    echo '<item>';
    echo '<title>Link</title>';
    echo '<link>'.$link.'</link>';
    //echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';

?>
</channel>
</rss>