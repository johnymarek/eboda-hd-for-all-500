<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">


<channel>
	<title>Metafeeds - all</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$html = file_get_contents("http://www.metafeeds.com/channel?show=all");

$html = str_between($html,'<h2>Channels</h2>','</table>');
//$videos = explode('class="noborder" style="width: 50%;">', $html);
$img = "http://www.metafeeds.com/static/images/feed_default.png";
$videos = explode('<tr>', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.metafeeds.com".$t2[0]."/rss";

    $t3 = explode('">', $t1[1]);
    $t4 = explode('<', $t3[1]);
    $title = trim($t4[0]);

    echo '<item>';
    print "\n";
    echo '<title>'.$title.'</title>';
    print "\n";
    echo '<link>'.$link.'</link>';
    print "\n";
    echo '<media:thumbnail url="'.$img.'" />';
    print "\n";
    print '</item>';
		print "\n";
		print "\n";
					
}

?>

</channel>
</rss>