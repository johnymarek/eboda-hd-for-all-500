<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>filmehd - filme noi</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
//http://www.filme-online.ucoz.com/news/2
if($page) {
    if($search) {
        $html = file_get_contents($search."/".$page);
    } else {
        $html = file_get_contents($search."/".$page."");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents($search);
    } else {
        $html = file_get_contents($search);
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
<link><?php echo $url;?></link><media:thumbnail url="http://all-free-download.com/images/graphiclarge/green_globe_left_arrow_558.jpg" />
</item>


<?php } ?>
<?php

$videos = explode('<div class="eTitle"', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
    $n = strlen($link);
 
//$link = rawurlencode($link);   
    $t1 = explode('img src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];
//$user = strstr($email, '@', true);
    $t1 = explode('<a href="', $video);
    $t2 = explode('</', $t1[1]);
    $title = substr($t2[0], $n+2);
//    echo $title;
//    $title = htmlspecialchars_decode($t2[0]);
//    $title = $t2[0];
	$link = str_replace(' ','%20',$link);
	$link = str_replace('[','%5B',$link);
	$link = str_replace(']','%5D',$link);
$pos = strpos($image, '.jpg');
if ($pos !== false) {
    $link = 'http://127.0.0.1:82/scripts/php/ucoz_link.php?file='.$link;
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';	
    echo '<media:thumbnail url="'.$image.'" />';
    echo '</item>';
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
<media:thumbnail url="http://all-free-download.com/images/graphiclarge/green_globe_right_arrow_559.jpg" />
</item>

</channel>
</rss>