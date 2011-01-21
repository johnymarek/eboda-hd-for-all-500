<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>serialepe.net</title>
	<menu>main menu</menu>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$link = $_GET["file"];
$html = file_get_contents($link);
	$videos = explode('flashVars',$html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
    $t1 = explode('mediaFile=', $video);
    $t2 = explode('&', $t1[1]);
    $link =$t2[0];
    $title = str_between($link,"http://","/");
    if ($link <> "") {
    echo '<item>';
    echo '<title>Link - '.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
    print "\n";
  }
  }

	$videos = explode('flashvars',$html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
    $t1 = explode('file=', $video);
    $t2 = explode('&', $t1[1]);
    $link =$t2[0];
    $title = str_between($link,"http://","/");
    if ($link <> "") {
    echo '<item>';
    echo '<title>Link - '.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
    print "\n";
  }
  }

	$videos = explode('<iframe',$html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
    $t1 = explode("src='", $video);
    $t2 = explode("'", $t1[1]);
    $link =$t2[0];
    $pos = strrpos($link, "novamov");
    if ($pos !== false) { 
		$html1 = file_get_contents($link);
		$link = str_between($html1,'"file","','"');
		
    if ($link <> "") {
    echo '<item>';
    echo '<title>Link - novamov</title>';
    echo '<link>'.$link.'</link>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
    print "\n";
  }
  }
  }

	$videos = explode('<script',$html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $link =$t2[0];
    
    $pos = strrpos($link, "peteava.ro");
    if ($pos !== false) { 
    $html1 = file_get_contents($link);
    $html1 = str_between($html1,'"flashvars"','pluginspage');
    $streamer = str_between($html1,'&streamer=','&');
    $id = str_between($html1,'id=','&');
    $file = str_between($html1,'file=','&');
    $link = $streamer.'?file='.$file.'&start=0&id='.$id.'&client=FLASH%20WIN%2010,0,45,2&version=4.2.95&width=624';
    $link = str_replace('&','&amp;',$link);
		
    if ($link <> "") {
    echo '<item>';
    echo '<title>Link - peteava</title>';
    echo '<link>'.$link.'</link>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
    print "\n";
  }
  }
  }
?>
</channel>
</rss>