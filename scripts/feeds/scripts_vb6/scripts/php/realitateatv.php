<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>Realitatea TV</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];

$html = file_get_contents($link);
//$link = str_between($html, '<div id="ve_listing_videos"', '</ul>');
$videos = explode('<li', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];	
//img src="http://vassets.realitatea.net/11/2010-06/fd46d299dacf119291c6f1ca5983f5bc_medium.jpg
//http://vcache.realitatea.net
		if (stripos($image,"_medium.jpg")!== false) {
    	$t1 = explode('title="', $video);
    	$t2 = explode('"', $t1[1]);
    	$title = $t2[0];
        	
			$link = str_replace('vassets.realitatea.net','vcache.realitatea.net',$image);
			$link = substr($link, 0, -11).".flv";
		
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    	echo '</item>';
			print "\n";
		}
	}
  
?>


</channel>
</rss>