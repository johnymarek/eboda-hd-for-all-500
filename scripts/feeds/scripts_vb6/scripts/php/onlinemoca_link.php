<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>onlinemoca.ro</title>
	<menu>main menu</menu>
<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$image = "/scripts/image/movies.png";
$search = $_GET["file"];

$baza = file_get_contents($search);

$html = str_between($baza,"Alege Una Din Variante","</table>");
$videos = explode('href', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
	$v1 = explode('="', $video);
	$v2 = explode('"', $v1[1]);
	$v3 = explode('=', $v2[0]);
	$link = $v3[1];
	$server = str_between($link,"http://","/");
	$title = $server;  
	$link = str_replace(' ','%20',$link);
	$link = str_replace('[','%5B',$link);
	$link = str_replace(']','%5D',$link);
	
	if (strpos($link, 'videoweed') !== false ) {
		$h1 = file_get_contents($link);
		$link1 = str_between($h1,'flashvars.file="','"');
		$title = $server." - ".substr(strrchr($link1,"/"),1);
	} elseif (strpos($link, 'novamov') !== false) {
		$h1 = file_get_contents($link);
		$link1 = str_between($h1,'flashvars.file="','"');
		$title = $server." - ".substr(strrchr($link1,"/"),1);
	} elseif (strpos($link, 'flvz') !== false) {
		$h1 = file_get_contents($link);
		$t1 = explode('<iframe',$h1);
		$t2 = explode('src="',$t1[1]);
		$t3 = explode('"',$t2[1]);
		$h1 = file_get_contents($t3[0]);
		$link1 = str_between($h1,'"url": "','"');
		$title = $server." - ".substr(strrchr($link1,"/"),1);
	} else {
		$link1="";
	}
	if (($link1 <> "") && strcmp($link1,$lastlink)) {
	echo'
<item>
<title>'.$title.'</title>
<link>'.$link1.'</link>
<media:thumbnail url="'.$image.'" />
<enclosure type="video/flv" url="'.$link1.'" />	
</item>
';
$lastlink = $link1;
}
}
// flash... mediafile,file.....
$videos = explode('flash', $baza);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1 = explode('ile=', $video);
  $t2 = explode('&', $t1[1]);
  $link = trim($t2[0]);
  $link = str_replace(' ','%20',$link);
	$link = str_replace('[','%5B',$link);
	$link = str_replace(']','%5D',$link);
	$server = str_between($link,"http://","/");
	$title = $server." - ".substr(strrchr($link,"/"),1); 
		if (($link <> "") && strcmp($link,$lastlink)) {
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    	echo '</item>';
    	print "\n";
    	$lastlink = $link;
  }
}
?>



</channel>
</rss>
