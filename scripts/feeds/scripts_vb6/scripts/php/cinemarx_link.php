﻿<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>www.cinemarx.ro</title>
	<menu>main menu</menu>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];
    $html = file_get_contents($link);
    $t1 = explode('rx_s.addVariable("file", "', $html);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
    
    echo '<item>';
    echo '<title>Link</title>';
    echo '<link>'.$link.'</link>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';

?>
</channel>
</rss>