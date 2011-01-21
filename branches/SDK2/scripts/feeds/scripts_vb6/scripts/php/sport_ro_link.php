<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>Sport.ro</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];


$html = file_get_contents($link);
$link = str_between($html, 'embed src=&quot;', '&');
if ($link <> "") {
$file = get_headers($link);

 foreach ($file as $key => $value)
   {
    if (strstr($value,"Location"))
     {
      $url = ltrim($value,"Location: ");
      $link = str_between($url,"file=","&");
     } // end if
   } // end foreach
   if ($link <> "") {
    echo '<item>';
    echo '<title>Link</title>';
    echo '<link>'.$link.'</link>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
}
}
?>


</channel>
</rss>