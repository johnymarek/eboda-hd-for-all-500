<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>TvBlog - orarul serialelor</title>
	<menu>main menu</menu>



<?php
$html = file_get_contents("http://www.tvblog.ro/orarul-serialelor/");

$videos = explode('<h4 class="orar_day"', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('>', $video);
    $t2 = explode('<', $t1[1]);
    $day = $t2[0];
    echo '<item>';
    echo '<title>================================'.$day.'================================</title>';	
    echo '<media:thumbnail url="/scripts/image/tvblog.jpg" />';
    echo '</item>';
    $days = explode('<div class="orar_item">',$video);
    unset($days[0]);
    $days = array_values($days);
    foreach($days as $serial) {
    	
    $t1 = explode('<img src="', $serial);
    $t2 = explode('"', $t1[1]);
    $image ='http://www.tvblog.ro'.$t2[0];
    
    $t1 = explode('<strong>', $serial);
    $t2 = explode('</strong>', $t1[1]);
    $title = $t2[0];

    echo '<item>';
    echo '<title>'.$title.'</title>';	
    echo '<media:thumbnail url="'.$image.'" />';
    echo '</item>';
}
}


?>

</channel>
</rss>