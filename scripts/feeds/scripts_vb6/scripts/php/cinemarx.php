﻿<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>Trailere filme noi</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

if($page) {
        $html = file_get_contents("http://www.cinemarx.ro/trailere/cele-mai-recente/".$page."/");
    }
else {
    $page = 1;
        $html = file_get_contents("http://www.cinemarx.ro/trailere/cele-mai-recente/1/");
    }


if($page > 1) { ?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",";
?>
<title>Previous Page</title>
<link><?php echo $url;?></link><media:thumbnail url="/scripts/image/left.jpg" />
</item>


<?php } ?>

<?php

$videos = explode('<li class="image">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="../../../', $video);
    $t2 = explode('"', $t1[1]);
    $link = 'http://www.cinemarx.ro/'.$t2[0];

    $t1 = explode(' title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];
    
    $t1 = explode(' src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];

    $html = file_get_contents($link);
    $t1 = explode('rx_s.addVariable("file", "', $html);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];


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
?>
<title>Next Page</title>
<link><?php echo $url;?></link>
<media:thumbnail url="/scripts/image/right.jpg" />
</item>

</channel>
</rss>