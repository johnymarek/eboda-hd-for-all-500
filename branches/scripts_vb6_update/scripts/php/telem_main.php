<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">


<channel>
	<title>telem</title>
	<menu>main menu</menu>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}

$html = file_get_contents("http://www.telem.ro/telem/");
$html = str_between($html,'<h3>Emisiuni</h3>','</ul>');

$videos = explode('<li', $html);
unset($videos[0]);
$videos = array_values($videos);
$img = "/scripts/image/telem.png";
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link ="http://www.telem.ro".$t2[0];

    $title = str_between($video,'<span>','<');

		$link="http://127.0.0.1:82/scripts/php/telem.php?query=,".$link;

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