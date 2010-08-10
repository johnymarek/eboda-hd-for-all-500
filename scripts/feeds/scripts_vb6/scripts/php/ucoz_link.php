<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>ucoz - links</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$n = 1;
$link = $_GET["file"];
//echo strrchr($link,"/");
$link = str_replace(' ','%20',$link);
$link = str_replace('[','%5B',$link);
$link = str_replace(']','%5D',$link);
$image = "http://ims.hdplayers.net/scripts/image/movies.png";

$html = file_get_contents($link);
$videos = explode('flashVars', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('mediaFile=', $video);
    $t2 = explode('&', $t1[1]);
    $link = $t2[0];
    $title = 'Link '.$n;
    if ($link <> "") {
		$pos = strpos($link, '.flv');
		if ($pos === false) {  
			$t1 = explode('mediaFile=', $video);
    	$t2 = explode('&', $t1[2]);
    	$link = $t2[0];	
  	}  
//  echo strrchr($link,"/");
		$link = str_replace(' ','%20',$link);
		$link = str_replace('[','%5B',$link);
		$link = str_replace(']','%5D',$link);
		$server = str_between($link,"http://","/");
		$file = substr(strrchr($link,"/"),1);
		$title = $server." - ".$file;
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
    $n=$n+1;
  }
}  

$videos = explode('flashvars', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('file=', $video);
    $t2 = explode('&', $t1[1]);
    $link = $t2[0];
    $title = 'Link '.$n;
    if ($link <> "") {

$link = str_replace(' ','%20',$link);
$link = str_replace('[','%5B',$link);
$link = str_replace(']','%5D',$link);
		$server = str_between($link,"http://","/");
		$file = substr(strrchr($link,"/"),1);
		$title = $server." - ".$file;
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
    $n=$n+1;
  }
}
// iframe  
$videos = explode('<iframe src', $html);

unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
	$link = str_between($video,'="','&');
	$server = str_between($link,"http://","/");
	if (strpos($link, 'videoweed') !== false) {
		$h1 = file_get_contents($link);
		$link1 = str_between($h1,'"file","','"');
		$title = $server." - ".substr(strrchr($link1,"/"),1);
	} elseif (strpos($link, 'novamov') !== false) {
		$h1 = file_get_contents($link);
		$link1 = str_between($h1,'"file","','"');
		$title = $server." - ".substr(strrchr($link1,"/"),1);
	} elseif (strpos($link, 'flvz') !== false) {
		//http://upstream.flvz.com/convertite/172.flv
		$link1 = "";
	} else {
		$link1="";
	}
	if ($link1 <> "") {
	echo'
<item>
<title>'.$title.'</title>
<link>'.$link1.'</link>
<media:thumbnail url="'.$image.'" />
<enclosure type="video/flv" url="'.$link1.'" />	
</item>
';
}
  }
?>


</channel>
</rss>