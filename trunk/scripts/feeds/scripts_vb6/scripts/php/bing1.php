<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
	<title>bing</title>
	<menu>main menu</menu>

<?php

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}

$file = $_GET["file"];
//$html = file_get_contents($file);
$html = file_get_contents("http://www.bing.com/videos/browse/source/fox-sports-fox-soccer-fsc?q=browse:source/fox+sports%3afox_soccer_fsc");
$videos = explode('<div class="info">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
    
    $t3 = explode('">',$t1[1]);
    $t4 = explode('<',$t3[1]);
    $title = $t4[0];

    $image = "http://ims.hdplayers.net/scripts/image/bing.jpg";
		$link = 'http://ims.hdplayers.net/scripts/php/bing_link.php?file='.$link;
		$data = str_between($video,'<span class="date p2-2">','</span>');
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<pubDate>'.$data.'</pubDate>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '</item>';
    print "\n";
}


?>

</channel>
</rss>