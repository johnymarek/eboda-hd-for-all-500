<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">


<channel>
	<title>www.cinemaxx.ro</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$html = file_get_contents("http://www.cinemaxx.ro/index.html");

$html = str_between($html,'<div id="list_cats">','</div>');
//http://www.cinemaxx.ro/browse-filme-actiune-online-videos-1-date.html
$img = "/scripts/image/movies.png";
$videos = explode('<li', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = rtrim($t2[0],"1-date.html");

    $t3 = explode('">', $t1[1]);
    $t4 = explode('<', $t3[1]);
    $title = $t4[0];

		$link1 = "http://127.0.0.1:82/scripts/php/cinemaxx.php?query=,".$link;
    echo '<item>';
    print "\n";
    echo '<title>'.$title.'</title>';
    print "\n";
    echo '<link>'.$link1.'</link>';
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