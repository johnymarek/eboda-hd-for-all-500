#!/usr/local/bin/Resource/www/cgi-bin/php
<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1/cgi-bin";
?>
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
		Bing
		</text>			
</mediaDisplay>
<channel>
	<title>bing</title>
	<menu>main menu</menu>

<?php

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}

$file = $_GET["file"];
$html = file_get_contents("http://www.bing.com/videos/browse/source/fox-sports-fox-soccer-fsc?q=browse:source/fox+sports%3afox_soccer_fsc");
$videos = explode('<div class="info">', $html);
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
    
    $t3 = explode('>',$t1[1]);
    $t4 = explode('<',$t3[1]);
    $title = $t4[0];

    $image = "/usr/local/etc/www/cgi-bin/scripts/tv/image/bing.jpg";
		$link = $host.'/scripts/tv/php/bing_link.php?file='.$link;
		$data = str_between($video,'<span class="date p2-2">','</span>');
    echo '
    <item>
    <title>'.$title.'</title>
    <link>'.$link.'</link>
    <pubDate>'.$data.'</pubDate>
    <media:thumbnail url="'.$image.'" />
    </item>
    ';
}


?>

</channel>
</rss>
