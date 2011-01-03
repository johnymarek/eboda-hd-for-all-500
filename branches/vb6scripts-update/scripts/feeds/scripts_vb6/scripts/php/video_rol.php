<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
	<title>video.rol.ro</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
//Funny-Cele_mai_noi
if($page) {
        $html = file_get_contents("http://video.rol.ro/categorii/".$search."/pagina_".$page.".htm");
    }
else {
    $page = 1;
        $html = file_get_contents("http://video.rol.ro/categorii/".$search."/pagina_1.htm");
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
//$v_id = str_between($html, '<ul class="video-tag-list">', '</ul>');

$videos = explode('<div  class="listare">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];

    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];

    $t1 = explode('class="font">', $video);
    $t2 = explode('<', $t1[1]);
    $title = $t2[0];

//$pos1 = stripos($link, 'source=');
//if ($pos1 === false) {
    $html = file_get_contents($link);
    //$link = urldecode(str_between($html, "url: '", "'"));
    $t1 = explode("url: '", $html);
    $t2 = explode("'", $t1[2]);
    $link = $t2[0];
//if($link=="") {
//	$link = str_between($html, "flashvars.video_url = '", "'");
//}
    //$html = file_get_contents($link);
    //$link = str_between($html, '<flv_url>', '</flv_url>');

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
<media:thumbnail url="/scripts/image/right.jpg" />
</item>

</channel>
</rss>