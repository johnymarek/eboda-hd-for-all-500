<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>tvt89</title>
	<menu>main menu</menu>

<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
if($page) {
	$page1=10*($page-1);
    if($search) {
        $html = file_get_contents("http://tvt89.bridgeman.ro/video.php?start=".$page."&tip=1");
    } else {
        $html = file_get_contents("http://tvt89.bridgeman.ro/video.php?start=".$page."&tip=1");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents("http://tvt89.bridgeman.ro/video.php?tip=1");
    } else {
        $html = file_get_contents("http://tvt89.bridgeman.ro/video.php?tip=1");
    }
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

$videos = explode('<td class="poza_video" valign="top">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
	    $t1 = explode('href="', $video);
	    $t2 = explode('"', $t1[1]);
			$link = "http://tvt89.bridgeman.ro/".$t2[0];
		
    	$t1 = explode('src="', $video);
    	$t2 = explode('"', $t1[1]);
    	$image = "http://tvt89.bridgeman.ro/".$t2[0];

    	$title = str_between($video,'<td class="nume_emisiune">','</td>');
    	$data = str_between($video,'<td class="data_emisiune">','</td>');
    	
			$html = file_get_contents($link);
			$link = "http://tvt89.bridgeman.ro/".str_between($html,"file=","&");
			$link = str_replace(' ','%20',$link);
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<pubDate>'.$data.'</pubDate>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '<enclosure type="video/flv" url="'.$link.'"/>';    		
    	echo '</item>';
    	print "\n";

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