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
$link = $_GET["file"];

//http://arhiva.telem.ro:8081/flv/2010/07/emisiuni/sperante6iul10.flv
//flv=2010/07/emisiuni/sperante6iul10
$html = file_get_contents($link);
$link = "http://arhiva.telem.ro:8081/flv/".str_between($html, 'arhiva/?flv=', '"').".flv";

    echo '<item>';
    echo '<title>Link</title>';
    echo '<link>'.$link.'</link>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';

  
?>


</channel>
</rss>