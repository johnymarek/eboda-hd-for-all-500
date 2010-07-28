<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>infotv.ro</title>
	<menu>main menu</menu>

<?php
//$html = file_get_contents("http://www.1tvbacau.ro/video/Stiri--c1.html");
$html = file_get_contents("http://www.infotv.ro/");
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}

$image = "/tmp/hdd/volumes/HDD1/scripts/image/infotv.gif";
$videos = explode('<li>', $html);

unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.infotv.ro".$t2[0];
    if (strpos($link,"news") !==false) {
    	$t3 = explode('>',$t1[1]);
    	$t4 = explode('<',$t3[1]);
    	$title = trim($t4[0]);
    	$title = str_between($link,"news/","/")." - ".$title;

			$link = 'http://127.0.0.1:82/scripts/php/infotv_link.php?file='.$link;

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '</item>';
    print "\n";
  }
}


?>

</channel>
</rss>