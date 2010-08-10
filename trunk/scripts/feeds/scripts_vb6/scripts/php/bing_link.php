<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>Bing</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];

$image = "http://ims.hdplayers.net/scripts/image/bing.jpg";
$html = file_get_contents($link);
$link = str_between($html, "formatCode: 1002, url: '", "'");
$link = str_replace('\x3a',':',$link);
$link = str_replace('\x2f','/',$link);
$link = str_replace(' ','%20',$link);
    echo '<item>';
    echo '<title>Link (wmv)</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/x-ms-wmv" url="'.$link.'"/>';	
    echo '</item>';

$link = str_between($html, "formatCode: 1003, url: '", "'");
$link = str_replace('\x3a',':',$link);
$link = str_replace('\x2f','/',$link);
    echo '<item>';
    echo '<title>Link (flv)</title>';
    echo '<link>'.$link.'</link>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
      
?>


</channel>
</rss>