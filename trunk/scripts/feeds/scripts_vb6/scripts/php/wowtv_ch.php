<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>wowtv</title>
	<menu>main menu</menu>


<?php
$query = $_GET["file"];
$html = file_get_contents($query);

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$html = str_between($html,'<ul class="vlist">','</ul>');
$videos = explode('<li class="clearfix', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];

    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];

    $t1 = explode('<h3><a href="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];
		$n = strlen($title);

    $t1 = explode('<h3><a href="', $video);
    $t2 = explode('<', $t1[1]);
    $title = substr($t2[0], $n+2);

		$html = file_get_contents($link);

    $t1 = explode(",{'url':'", $html);
    $t2 = explode("'", $t1[1]);
    $link = $t2[0];

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
}


?>

</channel>
</rss>