﻿<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>UEFA - training ground</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
//http://www.uefa.com/trainingground/video/index.html
//http://www.uefa.com/trainingground/video/index,page=2.htmx
if($page) {
    $html = file_get_contents("http://www.uefa.com/trainingground/video/index,page=".$page.".htmx");
} else {
    $page = 1;
    $html = file_get_contents("http://www.uefa.com/trainingground/video/index.html");
}

if($page > 1) { ?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Previous Page</title>
<link><?php echo $url;?></link><media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/left.jpg" />
</item>


<?php } ?>

<?php

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$videos = explode('<li id="A000', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('videoid=', $video);
    $t2 = explode('.', $t1[1]);
		$l = $t2[0];
		$newid = $t2[0];
		if ($l <> "") {
		//if (stripos($link,"videoid=")!== false){
			if (strlen($l) == 7) {
				$l="0".$l;
			for ($i = 0; $i <= 3; $i++) {
				$l1[$i] = substr($l,2*$i,2)."/";
			}
			$link = "http://www.uefa.com/News/".$l1[0].$l1[1].$l1[2].$l1[3]."xml/newsid=".$newid.",media.xml";
		}
			if (strlen($l) == 6) {
			for ($i = 0; $i <= 2; $i++) {
				$l1[$i] = substr($l,2*$i,2)."/";
			}
			$link = "http://www.uefa.com/News/".$l1[0].$l1[1].$l1[2]."xml/newsid=".$newid.",media.xml";
		}
			$html = file_get_contents($link);
			$link = "http://www.uefa.com".str_between($html,"<url>","</url>");
			
    	$t1 = explode('src="', $video);
    	$t2 = explode('"', $t1[1]);
    	$image = "http://www.uefa.com".$t2[0];

    	$t1 = explode('alt="', $video);
    	$t2 = explode('"', $t1[1]);
    	$title = trim($t2[0]);

    	$t1 = explode('<div class="newsDate">', $video);
    	$t2 = explode('<', $t1[1]);
    	$data = trim($t2[0]);
    		
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<pubDate>'.$data.'</pubDate>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '<enclosure type="video/flv" url="'.$link.'"/>';    		
    	echo '</item>';
    	print "\n";
		}
}


?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Next Page</title>
<link><?php echo $url;?></link>
<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/right.jpg" />
</item>

</channel>
</rss>