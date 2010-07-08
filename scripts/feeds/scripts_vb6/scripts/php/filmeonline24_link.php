<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>filmeonline24</title>
	<menu>main menu</menu>
<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$n=0;
$search = $_GET["file"];

$baza = file_get_contents($search);
$videos = explode('<embed', $baza);
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

$n++;
$titlu = 'Link '.$n;
$image = "/tmp/hdd/volumes/HDD1/scripts/image/movies.png";

$v1 = explode('mediaFile=', $video);
$v2 = explode('&', $v1[1]);
$link = $v2[0];  
$link = str_replace(' ','%20',$link);
$link = str_replace('[','%5B',$link);
$link = str_replace(']','%5D',$link); 
if($link=="") {
$v1 = explode('file=', $video);
$v2 = explode('.flv', $v1[1]);
$link = $v2[0];
$link = str_replace(' ','%20',$link);
$link = str_replace('[','%5B',$link);
$link = str_replace(']','%5D',$link); 
$link = $link.".flv"; 

}
$server = str_between($link,"http://","/");
$title = $server." - ".substr(strrchr($link,"/"),1);
if ($link <> ".flv") {
echo'
<item>
<title>'.$title.'</title>
<link>'.$link.'</link>
<media:thumbnail url="'.$image.'" />
<enclosure type="video/flv" url="'.$link.'" />	
</item>
';
}
}

$videos = explode('<iframe', $baza);
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
$n++;
$titlu = 'Link '.$n;
$image = "/tmp/hdd/volumes/HDD1/scripts/image/movies.png";

$link = str_between($video,"src='","'");
if (strpos($link, 'novamov') !== false) {
//http://embed.novamov.com/embed.php?width=600&#038;height=480&#038;v=tetm17nap7tyl
//http://embed.videoweed.com/embed.php?v=i7aegwa1bqo1t&#038;width=600&#038;height=480
	if (strpos($link, '?v=') === false) {
	$part = substr(strrchr($link,"v="),1);
	$link = "http://embed.novamov.com/embed.php?v".$part;	
} else {
	$part = str_between($link,"v=","&");
	$link = "http://embed.novamov.com/embed.php?v=".$part;
}
}

if (strpos($link, 'videoweed') !== false) {
//http://embed.novamov.com/embed.php?width=600&#038;height=480&#038;v=tetm17nap7tyl
//http://embed.videoweed.com/embed.php?v=i7aegwa1bqo1t&#038;width=600&#038;height=480
	if (strpos($link, '?v=') === false) {
	$part = substr(strrchr($link,"v="),1);
	$link = "http://embed.videoweed.com/embed.php?v".$part;	
} else {
	$part = str_between($link,"v=","&");
	$link = "http://embed.videoweed.com/embed.php?v=".$part;
}
}
$link = str_replace(' ','%20',$link);
$link = str_replace('[','%5B',$link);
$link = str_replace(']','%5D',$link); 
$baza = file_get_contents($link);
$v1 = explode('addVariable("file",', $baza);
$v2 = explode(')', $v1[1]);
$link = $v2[0];
$link = str_replace('"','',$link);
$link = str_replace("'",'',$link);
$link = str_replace(' ','%20',$link);
$link = str_replace('[','%5B',$link);
$link = str_replace(']','%5D',$link); 
$server = str_between($link,"http://","/");
$title = $server." - ".substr(strrchr($link,"/"),1);
echo'
<item>
<title>'.$title.'</title>
<link>'.$link.'</link>
<media:thumbnail url="'.$image.'" />
<enclosure type="video/flv" url="'.$link.'" />	
</item>
';
}

?>



</channel>
</rss>