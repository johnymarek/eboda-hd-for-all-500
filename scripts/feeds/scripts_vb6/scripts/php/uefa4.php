<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>UEFA - Weekly Edition</title>
	<menu>main menu</menu>

<?php
error_reporting(0);
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
if($page) {
    $html = file_get_contents("http://www.uefa.com/video/weeklyedition/index,page=".$page.".htmx");
} else {
    $page = 1;
    $html = file_get_contents("http://www.uefa.com/video/weeklyedition/index.html");
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
<link><?php echo $url;?></link><media:thumbnail url="/scripts/image/left.jpg" />
</item>


<?php } ?>

<?php

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$pos = strpos($html, '<li class="vThumbItem');
if ($pos === false) {
	$videos = explode('<li id="A000', $html);
} else {
$videos = explode('<li class="vThumbItem', $html);
}
//http://www.uefa.com/MultimediaFiles/int_interview/competitions/Comp_Matches/01/49/69/90/1496990_VIDEO.m4v
unset($videos[0]);
$videos = array_values($videos);
//var _flashVideoID='newsid=946335&amp;path=/video/weeklyedition/library/xml/newsid=946335,media.xml
foreach($videos as $video) {
    $t1 = explode('videoid=', $video);
    $t2 = explode('.', $t1[1]);
		$l = $t2[0];
		$newid = $t2[0];
		if ($l == ""){
			$t1 = explode('newsid=', $video);
    	$t2 = explode('.', $t1[1]);
			$l = $t2[0];
			$newid = $t2[0];
		}
		if ($l <> "") {
		//newsid=

			if (strlen($l) == 7) {
				$l="0".$l;
			for ($i = 0; $i <= 3; $i++) {
				$l1[$i] = substr($l,2*$i,2)."/";
			}
			$link = "";
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
			if ($link == "http://www.uefa.com") {
				$link = "http://www.uefa.com/video/weeklyedition/library/xml/newsid=".$newid.",media.xml";
				$html = file_get_contents($link);
				$link = "http://www.uefa.com".str_between($html,"<url>","</url>");
			}
			
    	$t1 = explode('src="', $video);
    	$t2 = explode('"', $t1[1]);
    	$image = "http://www.uefa.com".$t2[0];

    	$t1 = explode('alt="', $video);
    	$t2 = explode('"', $t1[1]);
    	$title = trim($t2[0]);

    	$t1 = explode('<div class="newsDate">', $video);
    	$t2 = explode('<', $t1[1]);
    	$data = trim($t2[0]);
    	if ($data == "") {
    		$t1 = explode('<div class="vdate w5">', $video);
    		$t2 = explode('<', $t1[1]);
    		$data = trim($t2[0]);
    }
    		
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
<media:thumbnail url="/scripts/image/right.jpg" />
</item>

</channel>
</rss>