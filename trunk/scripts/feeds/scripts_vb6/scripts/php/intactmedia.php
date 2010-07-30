<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>intactmedia.ro</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
//http://www.intactmedia.ro/video/?s=30&d=30&q=%2Fvideo%2F&o=td
//http://www.intactmedia.ro/video/?s=0&d=30&q=%2Fvideo%2F&o=td
if($page) {
	$page1=30*$page;
  $html = file_get_contents("http://www.intactmedia.ro/video/?s=".$page1."&d=30&q=%2Fvideo%2F&o=td");
} else {
  $page = 1;
	$html = file_get_contents("http://www.intactmedia.ro/video/?s=0&d=30&q=%2Fvideo%2F&o=td");
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
$videos = explode('<div class="wrap_image', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = 'http://www.intactmedia.ro'.$t2[0];

    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[2]);
    $image = $t2[0];

    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];

		$link = "http://127.0.0.1:82/scripts/php/intactmedia_link.php?file=".$link;

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
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
<media:thumbnail url="/scripts/image/right.jpg" />
</item>

</channel>
</rss>