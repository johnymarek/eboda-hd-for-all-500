<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">


<channel>
	<title>vezifilme.ro</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$html = file_get_contents("http://www.vezifilme.ro/");
$img = "/scripts/image/movies.png";
$html = str_between($html,'<div id="navigation_category">','</div>');
$videos = explode('<li class="cat-item', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link =$t2[0];
    
    $t1 = explode('title="View all posts filed under ', $video);
    $t2 = explode('"', $t1[1]);
    $title = trim($t2[0]);

if ($link <> "") {
		$link="http://127.0.0.1:82/scripts/php/vezifilme.php?query=,".$link;
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