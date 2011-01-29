#!/usr/local/bin/Resource/www/cgi-bin/php
﻿<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="20" idleImageHeightPC="26">
	<idleImage>image/POPUP_LOADING_01.png</idleImage>
	<idleImage>image/POPUP_LOADING_02.png</idleImage>
	<idleImage>image/POPUP_LOADING_03.png</idleImage>
	<idleImage>image/POPUP_LOADING_04.png</idleImage>
	<idleImage>image/POPUP_LOADING_05.png</idleImage>
	<idleImage>image/POPUP_LOADING_06.png</idleImage>
	<idleImage>image/POPUP_LOADING_07.png</idleImage>
	<idleImage>image/POPUP_LOADING_08.png</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		videopodcasts
		</text>			
</mediaDisplay>
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