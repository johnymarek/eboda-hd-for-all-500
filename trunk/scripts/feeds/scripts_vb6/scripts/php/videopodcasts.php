<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>videopodcasts</title>
	<menu>main menu</menu>


<?php
$link = $_GET["file"];
$html = file_get_contents($link);


$videos = explode('<td class="ltitle" style="text-align:left; padding: 2px;">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode("Subscribe to Podcast menu','", $video);
    $t2 = explode("'", $t1[1]);
    $link = $t2[0];
//http://www.vodcasts.tv/feedimg/473.jpg
    $t1 = explode('img src="', $video);
    $t2 = explode('f=', $t1[1]);
    $t3 = explode('"', $t2[1]);
    $image = "http://www.vodcasts.tv/".$t3[0];

    $t1 = explode('href="feed', $video);
    $t2 = explode('>', $t1[1]);
    $t3 = explode('<',$t2[1]);
    $title = $t3[0];


    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '</item>';
}


?>

</channel>
</rss>