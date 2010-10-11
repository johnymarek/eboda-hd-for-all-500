<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>wowtv.tv</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
//http://filmehd.net/page/2?s=comedie
//http://filmehd.net/actiune-filme/page/2
//http://www.filmeonlinegratis.ro/page/2
if($page) {
    if($search) {
        $html = file_get_contents($search."/page/".$page);
    } else {
        $html = file_get_contents("http://wowtv.tv/ratings?page=".$page."");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents($search);
    } else {
        $html = file_get_contents("http://wowtv.tv/ratings");
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

$videos = explode('<td class="rate-channel">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
    $n = strlen($link);
	$link = str_replace(' ','%20',$link);
	$link = str_replace('[','%5B',$link);
	$link = str_replace(']','%5D',$link); 
//$link = rawurlencode($link);   

    $image = "/scripts/image/wowtv.gif";

    $t1 = explode('<a href="', $video);
    $t2 = explode('<', $t1[1]);
    $title = substr($t2[0], $n+2);


    $link = 'http://127.0.0.1:82/scripts/php/wowtv_ch.php?file='.$link;
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