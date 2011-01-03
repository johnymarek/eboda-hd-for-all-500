<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>videopodcasts</title>
	<menu>main menu</menu>


<?php
$html = file_get_contents("http://www.videopodcasts.tv/");
$videos = explode("<a style='font-size:11px'", $html);

unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode("href='", $video);
    $t2 = explode("'", $t1[1]);
    $link = "http://www.vodcasts.tv/".$t2[0];
    $link = str_replace(' ','%20',$link);
    $link = "http://127.0.0.1:82/scripts/php/videopodcasts.php?file=".$link;

    $t1 = explode("href='", $video);
    $t2 = explode('>', $t1[1]);
    $t3 = explode('<', $t2[1]);
    $title = $t3[0];

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '</item>';
}


?>

</channel>
</rss>