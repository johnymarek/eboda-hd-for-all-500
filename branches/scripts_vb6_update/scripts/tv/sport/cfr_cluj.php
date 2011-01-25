<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" 
	itemBackgroundColor="0:0:0" 
	backgroundColor="0:0:0" 
	sideLeftWidthPC="0" 
	itemImageXPC="5" 
	itemXPC="20" 
	itemYPC="20" 
	itemWidthPC="65" 
	capWidthPC="70" 
	unFocusFontColor="101:101:101" 
	focusFontColor="255:255:255" 
	popupXPC = "40"
  popupYPC = "55"
  popupWidthPC = "22.3"
  popupHeightPC = "5.5"
  popupFontSize = "13"
	popupBorderColor="28:35:51" 
	popupForegroundColor="255:255:255"
 	popupBackgroundColor="28:35:51"
	idleImageXPC="45" 
	idleImageYPC="42" 
	idleImageWidthPC="20" 
	idleImageHeightPC="26">
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
		<script>getPageInfo("pageTitle");</script>
		</text>			
</mediaDisplay>
<channel>
	<title>CFR Cluj</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$host = "http://127.0.0.1:82";
$html = file_get_contents("http://www.cfr1907.ro/ro/multimedia/video/");
$items = explode('<div class="item">', $html);
unset($items[0]);
$items = array_values($items);

foreach($items as $item) {
	$videos = explode('<a href="',$item);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
    $t1 = explode('"', $video);
    $link = $t1[0];
    if (strpos($link,"multimedia") !== false) {
    $link = $host."/scripts/tv/sport/cfr_cluj_link.php?file="."http://www.cfr1907.ro".$link;

    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = "http://www.cfr1907.ro".$t2[0];

    $t1 = explode('title">', $video);
    $t2 = explode('<', $t1[1]);
    $title = $t2[0];
    
    $t1 = explode('"day">',$video);
    $t2 = explode('<',$t1[1]);
    $data = $t2[0].$t2[1].$t2[2];
		$data = str_replace("/span>"," ",$data);
		$data = str_replace("br />"," ",$data);

    echo '
    <item>
    <title>'.$title.'</title>
    <link>'.$link.'</link>
    <pubDate>'.$data.'</pubDate>
    <media:thumbnail url="'.$image.'" />
    </item>
    ';
  }
  }
}

?>

</channel>
</rss>
