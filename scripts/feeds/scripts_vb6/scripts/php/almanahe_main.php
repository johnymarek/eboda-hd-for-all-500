<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">


<channel>
	<title>almanahe.ro</title>
	<menu>main menu</menu>


<item>
<title>ultimele video</title>
<link>http://127.0.0.1:82/scripts/php/almanahe.php?query=,http://www.almanahe.ro/videos/all/latest</link>
<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/almanahe.png" />
</item>
<?php


$html = file_get_contents("http://www.almanahe.ro/channels/videos");


$videos = explode('<h1 class="content_heading">', $html);
unset($videos[0]);
$videos = array_values($videos);
$img = "/tmp/hdd/volumes/HDD1/scripts/image/almanahe.png";
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link =$t2[0];
    
    $t3 = explode('">', $t1[1]);
    $t4 = explode('<', $t3[1]);
    $title =$t4[0];



		$link="http://127.0.0.1:82/scripts/php/almanahe.php?query=,".$link;

    echo '<item>';
    print "\n";
    echo '<title>'.$title.'</title>';
    print "\n";
    echo '<link>'.$link.'</link>';
    print "\n";
    echo '<media:thumbnail url="'.$img.'" />';
    print "\n";
    print '</item>';
		print "\n";
		print "\n";
}
?>

</channel>
</rss>