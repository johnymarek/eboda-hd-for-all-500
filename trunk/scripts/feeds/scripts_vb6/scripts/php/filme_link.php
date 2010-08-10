<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>link</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}

$link = $_GET["file"];
$lastlink = "abc";
$link = str_replace(' ','%20',$link);
$link = str_replace('[','%5B',$link);
$link = str_replace(']','%5D',$link);
$image = "image/movies.png";

// flash... mediafile,file.....
$html = file_get_contents($link);
$videos = explode('flash', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1 = explode('ile=', $video);
  $t2 = explode('&', $t1[1]);
  $link = $t2[0];
  $link = str_replace(' ','%20',$link);
	$link = str_replace('[','%5B',$link);
	$link = str_replace(']','%5D',$link);
	//http%3A%2F
	$link = str_replace('%3A',':',$link);
	$link = str_replace('%2F','/',$link);
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
// <iframe , embed.....(novamov,videoweed,stagevu,divxstage.net,flvz.com)
//http://embed.novamov.com/embed.php?width=600&#038;height=480&#038;v=r10s5xdykpd6f 
//http://embed.videoweed.com/embed.php?v=72drqpukot88p&amp;width=500&amp;height=400
$videos = explode("<iframe", $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
	$t1 = explode('src="', $video);
	$t2 = explode('"', $t1[1]);
  $link = $t2[0];
  $link = str_replace('#038;','',$link); 
  $link = str_replace('&amp;','&',$link);
  if ((strpos($link, 'novamov') !== false) || (strpos($link, 'videoweed') !== false)) {
  		$baza = file_get_contents($link);
  		$v1 = explode('addVariable("file",', $baza);
			$v2 = explode(')', $v1[1]);
			$link = $v2[0];
			$link = str_replace('"','',$link);
			$link = str_replace("'","",$link);
		} elseif (strpos($link, 'movshare') !== false){
			$baza = file_get_contents($link);
			$link = str_between($baza,'addVariable("file","','"');
		} elseif (strpos($link, 'stagevu') !== false){
			$baza = file_get_contents($link);
			$link = str_between($baza,'param name="src" value="','"');
		} elseif (strpos($link, 'divxstage.net') !== false){
			$baza = file_get_contents($link);
			$link = str_between($baza,'"file","','"');
		} elseif (strpos($link, 'flvz.com') !== false){
			$baza = file_get_contents($link);
			$link = str_between($baza,'"url": "','"');
  } else {
  	$link = "";
  }

 		if (($link <> "") && strcmp($link,$lastlink)) {
			$link = str_replace('"','',$link);
			$link = str_replace("'","",$link);
			$link = str_replace(' ','%20',$link);
			$link = str_replace('[','%5B',$link);
			$link = str_replace(']','%5D',$link); 
			$server = str_between($link,"http://","/");
			$title = $server." - ".substr(strrchr($link,"/"),1);
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

$videos = explode("<iframe", $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
	$t1 = explode("src='", $video);
	$t2 = explode("'", $t1[1]);
  $link = $t2[0];
  $link = str_replace('#038;','',$link); 
  if ((strpos($link, 'novamov') !== false) || (strpos($link, 'videoweed') !== false)) {
  		$baza = file_get_contents($link);
  		$v1 = explode('addVariable("file",', $baza);
			$v2 = explode(')', $v1[1]);
			$link = $v2[0];
			$link = str_replace('"','',$link);
			$link = str_replace("'","",$link);
		} elseif (strpos($link, 'movshare') !== false){
			$baza = file_get_contents($link);
			$link = str_between($baza,'addVariable("file","','"');
		} elseif (strpos($link, 'stagevu') !== false){
			$baza = file_get_contents($link);
			$link = str_between($baza,'param name="src" value="','"');
		} elseif (strpos($link, 'divxstage.net') !== false){
			$baza = file_get_contents($link);
			$link = str_between($baza,'"file","','"');
		} elseif (strpos($link, 'flvz.com') !== false){
			$baza = file_get_contents($link);
			$link = str_between($baza,'"url": "','"');
  } else {
  	$link = "";
  }

 		if (($link <> "") && strcmp($link,$lastlink)) {
			$link = str_replace('"','',$link);
			$link = str_replace("'","",$link);
			$link = str_replace(' ','%20',$link);
			$link = str_replace('[','%5B',$link);
			$link = str_replace(']','%5D',$link); 
			$server = str_between($link,"http://","/");
			$title = $server." - ".substr(strrchr($link,"/"),1);
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

//jurnaltv.ro
if (strpos($html, 'jurnaltv.ro') !== false) {
	$link = str_between($html,'vPlayer.swf?f=','"');
	$h = file_get_contents($link);
	$link = str_between($h,"<src>","</src>");
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
 //stagevu.ro
 if (strpos($html, 'stagevu.ro') !== false) {
 	$link = str_between($html,"'video/divx' src='","'");
	$server = str_between($link,"http://","/");
	$title = $server." - ".substr(strrchr($link,"/"),1); 
	if (($link <> "") && strcmp($link,$lastlink)) {
		  echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '<enclosure type="video/divx" url="'.$link.'"/>';	
    	echo '</item>';
    	print "\n";
    	$lastlink = $link;
    }
  }
//stagevu.com
 if (strpos($html, 'stagevu.com') !== false) {
 	$link = str_between($html,"] = '","'");
	$server = str_between($link,"http://","/");
	$title = $server." - ".substr(strrchr($link,"/"),1); 
	if (($link <> "") && strcmp($link,$lastlink)) {
		  echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '<enclosure type="video/divx" url="'.$link.'"/>';	
    	echo '</item>';
    	print "\n";
    	$lastlink = $link;
    }
  }
//www.4shared.com/embed/264489980/d9d252d8
 if (strpos($html, '4shared.com/embed') !== false) {
	$videos = explode("<embed", $html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) { 	
 		$link = str_between($video,'src="','"');
 		if (strpos($video, '4shared.com/embed') !== false) {
		$file = get_headers($link);
 		foreach ($file as $key => $value)
   	{
    if (strstr($value,"Location"))
     {
      $url = ltrim($value,"Location: ");
      $link = str_between($url,"file=","&");
     } // end if
   	} // end foreach
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
}
}
//encodeURIComponent (efilmeonline.ro)
 if (strpos($html, 'encodeURIComponent') !== false) {
	$videos = explode("SWFObject", $html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) { 	
 		$link = str_between($video,"encodeURIComponent('","'");
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
}
//flashvars="playlistfile=
if (strpos($html, 'flashvars="playlistfile=') !== false) {
	$t1=explode('flashvars="playlistfile=',$html);
	$link = str_between($t1[1],"file=","&");
	$server = str_between($link,"http://","/");
	$title = $server." - ".substr(strrchr($link,"/"),1); 
	if (($link <> "") && strcmp($link,$lastlink)) {
		  echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';	
    	echo '</item>';
    	print "\n";
    	$lastlink = $link;
  }
}
//4shared.com
if (strpos($html, '4shared.com') !== false) {
	$videos = explode("SWFObject", $html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) { 	
	$link = str_between($video,"'file','","'");
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
}
//megavideo
if (strpos($html, 'megavideo') !== false) {
$videos = explode('<object', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
	$link = str_between($video,'value="','"');
	//echo $link;
	if (strpos($link,"megavideo") !== false) {
	$file = get_headers($link);
 	foreach ($file as $key => $value)
   {
    if (strstr($value,"location"))
     {
      $url = ltrim($value,"location: ");
      $link = substr(strrchr($url, '='),1);
     } // end if
   } // end foreach
   $id = $link;
	 $title = "megavideo (V1) - file=".$id;
   //$link = "http://estosesale.com/megavideotito3.php?video_id=".$id;
   //http://ezywatch.com/
   $link = "http://ezywatch.com/".$id.".flv";
   if (strcmp($link,$lastlink)) {
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
    print "\n";
    $lastlink = $link;
  }
  }
}
}
?>

</channel>
</rss>