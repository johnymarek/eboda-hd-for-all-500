<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<mediaDisplay name="threePartsView" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="40" idleImageYPC="40" idleImageWidthPC="20" idleImageHeightPC="26">
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		filme online ucoz.com
		</text>	
        <idleImage>/scripts/scripts9/image/busy1.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy2.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy3.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy4.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy5.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy6.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy7.png</idleImage>
        <idleImage>/scripts/scripts9/image/busy8.png</idleImage>
	</mediaDisplay>
<channel>
	<title>filmehd - main</title>
	<menu>main menu</menu>
	<item>
		<title>Filme Noi</title>
	<link>http://127.0.0.1:82/scripts/php/ucoz.php?query=,http://www.filme-online.ucoz.com/news</link>
	<media:thumbnail url="/scripts/image/movies.png" />
	</item>
<?php
//<li class="cat-item
$html = file_get_contents("http://www.filme-online.ucoz.com/");
$videos = explode('class="catsTd" valign="top">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	$link = str_replace(' ','%20',$link);
	$link = str_replace('[','%5B',$link);
	$link = str_replace(']','%5D',$link);   

    $t1 = explode('"catName">', $video);
    $t2 = explode('<', $t1[1]);
    $title = $t2[0];
    //$link = 'http://127.0.0.1:82/scripts/php/filmehd_link.php?file='.$link;
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>http://127.0.0.1:82/scripts/php/ucoz.php?query=,'.$link.'</link>';	
    echo '<media:thumbnail url="/scripts/image/movies.png" />';
    echo '</item>';
}
?>
</channel>
</rss>