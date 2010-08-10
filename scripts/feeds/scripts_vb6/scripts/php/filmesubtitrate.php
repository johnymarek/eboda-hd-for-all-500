<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">


<channel>
	<title>filmesubtitrate</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

$html = file_get_contents($search);
$series = explode('<ol', $html);
unset($series[0]);
$series = array_values($series);
foreach($series as $serie) {
	$videos = explode('<li>',$serie);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link =$t2[0];

    $pos = strrpos($link, "online");
		if ($pos === false) {
    $t1 = explode('">', $video);
    $t2 = explode('<', $t1[1]);
    $title = trim($t2[0]);
    
if ($link <> "") {
		$link="http://ims.hdplayers.net/scripts/php/filmesubtitrate_link.php?file=".$link;
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    print '</item>';
		print "\n";
}
}
}
}
?>

</channel>
</rss>