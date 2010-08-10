<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="20" idleImageHeightPC="26">
	<idleImage>image/busy1.png</idleImage>
	<idleImage>image/busy2.png</idleImage>
	<idleImage>image/busy3.png</idleImage>
	<idleImage>image/busy4.png</idleImage>
	<idleImage>image/busy5.png</idleImage>
	<idleImage>image/busy6.png</idleImage>
	<idleImage>image/busy7.png</idleImage>
	<idleImage>image/busy8.png</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		ucoz.com
		</text>			
</mediaDisplay>
<channel>
	<title>ucoz.com</title>
	<menu>main menu</menu>
	<item>
		<title>Filme Noi</title>
	<link>http://ims.hdplayers.net/scripts/php/ucoz.php?query=,http://www.filme-online.ucoz.com/news</link>
	<media:thumbnail url="image/movies.png" />
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
    //$link = 'http://ims.hdplayers.net/scripts/php/filmehd_link.php?file='.$link;
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>http://ims.hdplayers.net/scripts/php/ucoz.php?query=,'.$link.'</link>';	
    echo '<media:thumbnail url="image/movies.png" />';
    echo '</item>';
}
?>
</channel>
</rss>