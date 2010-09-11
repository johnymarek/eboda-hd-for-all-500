<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>All Videos</title>
	<menu>main menu</menu>

<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

if($page) {
    if($search) {
        $html = file_get_contents("http://www.livesoccertv.com/videos/".$page."/");
    } else {
        $html = file_get_contents("http://www.livesoccertv.com/videos/".$page."/");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents("http://www.livesoccertv.com/videos/");
    } else {
        $html = file_get_contents("http://www.livesoccertv.com/videos/");
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
<link><?php echo $url;?></link><media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/left.jpg" />
</item>


<?php } ?>

<?php

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
//$html = str_between($html,'<th width="15%">Stage</th>','</table>');
$image = "/tmp/hdd/volumes/HDD1/scripts/image/livesoccertv.gif";
$videos = explode('<div id="videolink">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[2]);
		$link = "http://www.livesoccertv.com".$t2[0];
		if (strpos($link, "/match") === false) {
			$t2 = explode('"', $t1[2]);
		}
		$link = "http://www.livesoccertv.com".$t2[0];
		$link = "http://127.0.0.1:82/scripts/php/livesoccertv_link.php?file=".$link;
		
//    	$t1 = explode('src="', $video);
//    	$t2 = explode('"', $t1[1]);
//    	$image = "http://www.uefa.com".$t2[0];

    	$t1 = explode('title="', $video);    	
    	$t3 = explode('>',$t1[2]);
    	$t4 = explode('<', $t3[1]);
    	$title1 = $t4[0];
    	
    	$t5 = explode('</a>',$t1[2]);
    	$t6 = explode('<', $t5[1]);
    	$title2 = $t6[0];
    	$title = $title1." ".$title2;

    	$t1 = explode('border=0/></a>', $video);
    	$t2 = explode('<', $t1[1]);
    	$data = trim($t2[0]);
    	if ($data == "") {
    		$data = str_between($video,'border="0">','<a href');
    		$data = trim(str_replace('</a>','',$data));
    	}
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<pubDate>'.$data.'</pubDate>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
//    	echo '<enclosure type="video/flv" url="'.$link.'"/>';    		
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
<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/right.jpg" />
</item>
</channel>
</rss>