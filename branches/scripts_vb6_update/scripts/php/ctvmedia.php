<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>ctvmedia.ro</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

if ($page > 1) {
	$page1 = 5* ($page - 1);
	$html = file_get_contents("http://www.ctvmedia.ro/index.php?limitstart=".$page1);
} else {
	$page = 1;
	$html = file_get_contents("http://www.ctvmedia.ro/index.php");
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
$image = "/scripts/image/ctvmedia.jpg";
$videos = explode('<div class="contentpaneopen">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
		$link = str_between($video,'value="file=','&');
		$link = str_replace(" ","%20",$link);
    $title = trim(str_between($video,'<h2 class="contentheading">','</h2>'));
		$data =  trim(str_between($video,'<span class="createdate">','</span>'));
	
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<pubDate>'.$data.'</pubDate>';
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