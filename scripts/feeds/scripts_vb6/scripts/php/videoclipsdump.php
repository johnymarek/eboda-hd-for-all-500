﻿<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>videoclipsdump</title>
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
        $html = file_get_contents("http://www.videoclipsdump.com/c/All/".$page."/");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents("http://www.tube8.com/search.html?q=".$search);
    } else {
        $html = file_get_contents("http://www.videoclipsdump.com/c/All/1");
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

$videos = explode('style="width:1%;">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode("<a href='", $video);
    $t2 = explode("'", $t1[1]);
    $link = $t2[0];

    $t1 = explode("src='", $video);
    $t2 = explode("'", $t1[1]);
    $image = $t2[0];

    $t1 = explode('<span class="desc">', $video);
    $t2 = explode('<', $t1[1]);
    $title = $t2[0];

    $html = file_get_contents($link);
    $t1 = explode('simple.swf?url=', $html);
    $t2 = explode('&', $t1[1]);
    $link = $t2[0];
$pos = strpos($link, '.flv');
if ($pos !== false) {
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
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
<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/right.jpg" />
</item>

</channel>
</rss>