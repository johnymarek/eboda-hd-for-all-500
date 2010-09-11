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
$html = file_get_contents("http://www.filmesubtitrate.info/p/seriale-online-subtitrate-in-romana.html");

$html = str_between($html,'<table border="0" cellpadding="0" cellspacing="0" style="width: 600px;"><tbody>','</table>');
$videos = explode('<td>', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link =$t2[0];

    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $img =$t2[0];
    $pos = strrpos($img, "?");
		if ($pos !== false) { 
			$img = trim(substr($img,0,$pos));
		}    

    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = trim($t2[0]);
		$pos = strrpos($title, "serial"); 
		if ($pos !== false) { 
			$title = trim(substr($title,0,$pos));
		}
if ($link <> "") {
		$link="http://127.0.0.1:82/scripts/php/filmesubtitrate.php?query=1,".$link;
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$img.'" />';
    print '</item>';
		print "\n";
}
}
?>

</channel>
</rss>