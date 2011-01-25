<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
<rss version="2.0" xmlns:media="http://purl.org/dc/elements/1.1/">
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
		TvBlog - orarul serialelor
		</text>			
</mediaDisplay>
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
    echo '<media:thumbnail url="/scripts/news/image/tvblog.jpg" />';
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
