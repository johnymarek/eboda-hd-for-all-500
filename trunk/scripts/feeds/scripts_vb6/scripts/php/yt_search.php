<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>YouTube - Search</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
//http://www.youtube.com/results?search_query=abba&aq=f&page=2
if($page) {
    if($search) {
        $html = file_get_contents("http://www.youtube.com/results?search_query=".$search."&aq=f&page=".$page);
    } else {
        $html = file_get_contents("http://www.youtube.com/videos?s=mp&t=t&cr=US&p=".$page."");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents("http://www.youtube.com/results?search_query=".$search."&aq=f");
    } else {
        $html = file_get_contents("http://www.youtube.com/videos?s=mp&t=t&cr=US&p=1");
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
$videos = explode('<div class="video-entry yt-uix-hovercard">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode(' href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = 'http://www.youtube.com'.$t2[0].'&hd=1';

    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = htmlspecialchars_decode($t2[0]);

    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];
$pos = strrpos($image, ".jpg");
if ($pos === false) { // note: three equal signs
    $t1 = explode('thumb="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];
}    

//    $html = file_get_contents($link);
//    $t1 = explode(' videourl="', $html);
//    $t2 = explode('"', $t1[1]);
//    $link = $t2[0];
$youtube_page = file_get_contents($link);
$v_id = str_between($youtube_page, "&video_id=", "&");
$t_id = str_between($youtube_page, "&t=", "&");
//$flv_link = "http://www.youtube.com/get_video?video_id=$v_id&t=$t_id";
$flv_link = "http://127.0.0.1:82/scripts/php/yt.php?id=".$v_id ;
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$flv_link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/mp4" url="'.$flv_link.'"/>';
    echo '<media:player url="'.$flv_link.'"/>';	
    echo '</item>';
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