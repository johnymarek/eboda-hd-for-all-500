<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>tvtargoviste.ro</title>
	<menu>main menu</menu>


<?php
$html = file_get_contents("http://www.tvtargoviste.ro/index.php?option=com_content&view=section&layout=blog&id=1&Itemid=98");

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$image = "http://ims.hdplayers.net/scripts/image/tvtargoviste.png";
$videos = explode('<div class="article_column', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.tvtargoviste.ro".$t2[0];

    $title = str_between($video,'class="contentpagetitle">','</a>');
    $title = trim($title);
    
    $data = trim(str_between($video,'<span class="createdate">','<'));
    $data = str_replace("</em>","",$data);
    $data = str_replace("<span>","",$data);
    $data = str_replace("&ndash;","",$data);
    //$link = "http://ims.hdplayers.net/scripts/php/televiziuneaseverin_link.php?file=".$link;
    $link = str_replace("&amp;","&",$link);
		$html = file_get_contents($link);
		//echo $html;
		$link = str_between($html, 'www.youtube.com/v/', '"');
		$link = str_replace(" ","%20",$link);
		$link = "http://127.0.0.1:82/scripts/php/yt.php?id=".$link ;
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<pubDate>'.$data.'</pubDate>';
    echo '<media:thumbnail url="'.$image.'" />';	
    echo '<enclosure type="video/flv" url="'.$link.'"/>';
    echo '</item>';
    print "\n";
}


?>

</channel>
</rss>