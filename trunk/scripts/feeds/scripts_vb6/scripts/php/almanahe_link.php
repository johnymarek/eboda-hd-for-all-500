﻿<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>almanahe.ro</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];


$html = file_get_contents($link);
$link = urldecode(str_between($html, 'configXML=', '&'));
//http://www.almanahe.ro/ajax/getVideoXml/1822
//http://www.almanahe.ro/data/videos/1822/1822.flv
//http://www.almanahe.ro/data/videos/1822/1822_orig.flv
//$html = file_get_contents($link);
$link1 = strrchr($link, "/");
$link = "http://www.almanahe.ro/data/videos".$link1.$link1."_orig.flv";

    echo '<item>';
    echo '<title>Link</title>';
    echo '<link>'.$link.'</link>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';

  
?>


</channel>
</rss>