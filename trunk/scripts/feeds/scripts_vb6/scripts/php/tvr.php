<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>tvr</title>
	<menu>main menu</menu>


<?php
$id = $_GET["id"];

$html = file_get_contents("http://tvr.ro/emisiune.php?id=".$id);

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$image = "http://ims.hdplayers.net/scripts/image/tvr.jpg";
$videos = explode('<div class="text_med">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('file=', $video);
    $t2 = explode('&', $t1[1]);
    $link = $t2[0];
		$link = "http://127.0.0.1/cgi-bin/rtmp?".$link;
		
    $t1 = explode('name=', $video);
    $t2 = explode("'", $t1[1]);
    $title2 = $t2[0];

		$title1 = str_between($video,'<span class="text_negru">','<');
		$title = $title2." - ".$title1;

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';
    echo '</item>';
    print "\n";
}

?>

</channel>
</rss>