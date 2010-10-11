<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>mediadirect - desene animate</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

if($page) {
  $html = file_get_contents("http://www.mediadirect.ro/desene-pagina-".$page.".html");
} else {
  $page = 1;
	$html = file_get_contents("http://www.mediadirect.ro/desene-pagina-1.html");
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
$html = str_between($html,'<div id="thumb-group">','<p class="pages">');
$videos = explode('<div class="gratis">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];

    $title = str_between($video,"<b>","</b>");
    $link = str_replace(' - ','_',$title);
    $link = str_replace(' ','_',$link);

		$link = "http://127.0.0.1:82/cgi-bin/rtmp?rtmpe://fms8.mediadirect.ro:1935/desene_animate?id=1676684/mp4:".$link.".mp4";
if ((strpos($title,'<') === false) && ($title <> "")) {
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/mp4" url="'.$link.'"/>';
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