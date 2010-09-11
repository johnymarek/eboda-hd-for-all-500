<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>divxonline.biz</title>
	<menu>main menu</menu>


<?php
$html = file_get_contents("http://divxonline.biz/index.php");
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$image = "/tmp/hdd/volumes/HDD1/scripts/image/divxonline.png";
$videos = explode('<ul', $html);
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
	$vids = explode('<li>', $video);
	unset($vids[0]);
	$vids = array_values($vids);
	foreach($vids as $vid) {
		
    $t1 = explode('href="', $vid);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
    if (strpos($link,"?do=cat") !== false) {
    	$t3 = explode("category=",$link);
    	$link1 ="http://127.0.0.1:82/scripts/php/divxonline.php?query=,http://divxonline.biz/".$t3[1]."/";
    	$t1 = explode('title="', $vid);
    	$t2 = explode('"', $t1[1]);
    	$title = $t2[0];

    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<link>'.$link1.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '</item>';
    	print "\n";
  	} elseif (strpos($link,"serialetv") !== false) {
  		$link1 = "http://127.0.0.1:82/scripts/php/divxonline.php?query=,http://divxonline.biz".$link;
  		$t1 = explode('title="', $vid);
    	$t2 = explode('"', $t1[1]);
    	$title = $t2[0];

    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<link>'.$link1.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '</item>';
    	print "\n";
    }
  		
}
}

?>

</channel>
</rss>