<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>myspace.com</title>
	<menu>main menu</menu>


<?php
$suf1 = "/vid.mp4";
$suf2 = "/vid.flv";
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

if($page) {
	$html = file_get_contents("http://vids.myspace.com/index.cfm?fuseaction=vids.viewVideos&contributorid=43189980&page=".$page);
} else {
    $page = 0;
		$html = file_get_contents("http://vids.myspace.com/index.cfm?fuseaction=vids.viewVideos&contributorid=43189980&page=".$page);
}
//MythBusters | Discovery Channel's Videos
//$html = file_get_contents("http://vids.myspace.com/index.cfm?fuseaction=vids.viewVideos&contributorid=32792700&page=");
if($page > 0) { ?>

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

$videos = explode('<div class="vcontainer">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];

    $t1 = explode('<a title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];

			$link = str_replace('thumb1_','',$image);
			$link = str_replace('thumb2_','',$link);
			$link = str_replace('.jpg','',$link);
			$part = substr($link,34);
			$link = "http://l3-hl1.videos02.myspacecdn.com".$part.$suf1; //mp4
			$AgetHeaders = @get_headers($link);
			if (!preg_match("|200|", $AgetHeaders[0])) {
				$link = "http://l3-hl1.videos02.myspacecdn.com".$part.$suf2; //flv	
				$AgetHeaders = @get_headers($link);
				if (!preg_match("|200|", $AgetHeaders[0])) {
					$link = "http://l3-hl1xl.myspacecdn.cust.footprint.net".$part.$suf1; //mp4
					$AgetHeaders = @get_headers($link);
					if (!preg_match("|200|", $AgetHeaders[0])) {
						$link = "http://l3-hl1xl.myspacecdn.cust.footprint.net".$part.$suf2; //flv
					}
				}
			}

			echo '<item>';
    	echo '<title>'.$title.'</title>';
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
<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/right.jpg" />
</item>

</channel>
</rss>