﻿<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>In gura presei - Politic</title>
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
        //$html = file_get_contents("http://ingurapresei.antena1.ro/emisiuni".$page."");
		$html = file_get_contents("http://ingurapresei.antena1.ro/ajax.php?action=showVideosArchive&section=politic&limit=10&page=".$page."&offset=0");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents("http://www.tube8.com/search.html?q=".$search);
    } else {
        //$html = file_get_contents("http://ingurapresei.antena1.ro/emisiuni");
		$html = file_get_contents("http://ingurapresei.antena1.ro/ajax.php?action=showVideosArchive&section=politic&limit=10&page=".$page."&offset=0");
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


$videos = explode('<div class="thumb" style="position:relative;top:0px;left:0px;">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = 'http://ingurapresei.antena1.ro'.$t2[0];

    $t1 = explode(' src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];

    $t1 = explode(' class="boxLink">', $video);
    $t2 = explode('</a>', $t1[1]);
    $title = $t2[0];

    $html = file_get_contents($link);
    $t1 = explode('thumbs/antena1/', $html);
    $t2 = explode('_', $t1[1]);
    $link = 'http://vodh1.inin.ro/antena1/'.$t2[0].'.mp4';
	
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/mp4" url="'.$link.'"/>';	
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