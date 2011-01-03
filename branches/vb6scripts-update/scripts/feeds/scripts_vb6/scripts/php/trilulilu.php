<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
	<title>www.trilulilu.ro</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
//http://www.trilulilu.ro/video/cele-mai-recente/azi?page=2
//http://www.trilulilu.ro/video/Animale/cele-mai-recente/azi?page=2
if($page) {
        $html = file_get_contents($search."?page=".$page);
    }
else {
    $page = 1;
        $html = file_get_contents($search);
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

$videos = explode('<div class="thumbnail">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];

    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];

    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];

    $html = file_get_contents($link);

		$name = str_between($html, 'so.addVariable("name", "', '"');
		$name = str_replace(' ','_',$name);
		$name = str_replace('(','_',$name);
		$name = str_replace(')','_',$name);
		//$name = str_replace('\\','_',$name);
		
		$userid = str_between($html, 'so.addVariable("userid", "', '"');
		$hash = str_between($html, 'so.addVariable("hash", "', '"');
		$server = str_between($html, 'so.addVariable("server", "', '"');
		$key = str_between($html, 'so.addVariable("key", "', '"');

		$link="http://fs".$server.".trilulilu.ro/stream.php?type=video&hash=".$hash."&username=".$userid."&key=".$key."&tip=.flv&nume=".$name."&submitd=Descarca+.flv";
		$link = str_replace('&','&amp;',$link);
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