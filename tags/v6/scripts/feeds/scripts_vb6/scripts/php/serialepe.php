﻿<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">


<channel>
	<title>serialepe.net</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];
$html = file_get_contents($link);

$html = str_between($html,"<div class='post-body'>","EtargetSearchQuery");
//$videos = explode('class="noborder" style="width: 50%;">', $html);
//<td class="" style="width: 50%;">
$videos = explode('<a', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];

    $t1 = explode('">', $video);
    $t2 = explode('<', $t1[1]);
    $title = trim($t2[0]);

    $img = "/scripts/image/serialepenet.png";
		if ($link <> "") {
		$link = "http://127.0.0.1:82/scripts/php/serialepe_link.php?file=".$link;
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
}

?>

</channel>
</rss>