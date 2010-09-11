<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>clearclips</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];
//echo strrchr($link,"/");
$link = str_replace(' ','%20',$link);
$link = str_replace('[','%5B',$link);
$link = str_replace(']','%5D',$link);
$image = "/tmp/hdd/volumes/HDD1/scripts/image/clearclips.gif";
$title = "Link";
//    $html = file_get_contents($link);
//    $link = urldecode(str_between($html, "s1.addParam('flashvars','file=", "&"));

$html = file_get_contents($link);
$link = str_between($html, "so.addVariable('file','", "'");
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';

  
?>


</channel>
</rss>