<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>Metacafe - most popular</title>
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
        $html = file_get_contents("http://www.tube8.com/search.html?q=".$search."&page=".$page);
    } else {
        $html = file_get_contents("http://www.metacafe.com/most_popular/page-".$page."/");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents("http://www.tube8.com/search.html?q=".$search);
    } else {
        $html = file_get_contents("http://www.metacafe.com/most_popular/page-1/");
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
$videos = explode('<li id="i1', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = 'http://www.metacafe.com'.$t2[0];

    $t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];

    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];

//    $html = file_get_contents($link);
//    $t1 = explode(' videourl="', $html);
//    $t2 = explode('"', $t1[1]);
//    $link = $t2[0];
$html = file_get_contents($link);
$link = urldecode(str_between($html, '<object classid="', '</object>'));

//"mediaURL":"http:\/\/akvideos.metacafe.com\/ItemFiles\/%5BFrom%20www.metacafe.com%5D%204427778.13709542.11.flv"}
$link = str_between($link,'"mediaURL":"','"');
//echo $mu;
//$link = urldecode($link);
//http:\/\/akvideos.metacafe.com\/ItemFiles\/[From www.metacafe.com] 4427778.13709542.11.flv
$link= str_replace('\/','/',$link);
$link = str_replace(' ','%20',$link);
$link = str_replace('[','%5B',$link);
$link = str_replace(']','%5D',$link);
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
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