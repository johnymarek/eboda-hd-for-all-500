<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name=photoView
	drawItemText=yes 
	columnCount=6 rowCount=6 
	itemBackgroundColor=0:0:0
	backgroundColor=0:0:0
	sideLeftWidthPC=10
	sideRightWidthPC=100
	fontSize=16
	showHeader="no"
	headerXPC=101
	headerYPC=101
	headerImageXPC=101 
	headerImageYPC=101
	itemImageXPC="9" 
	itemImageYPC="21"
    itemImageHeightPC="12" 
	itemImageWidthPC="1"           
    itemXPC="28"
    itemYPC="20.5"
	itemPerPage="5"			
	popupXPC = 7
	popupYPC = 21
	popupFontSize = 17
	popupWidthPC = 15
	popupBorderColor = 0:0:0>
		<idleImage> image/POPUP_LOADING_01.jpg </idleImage>
		<idleImage> image/POPUP_LOADING_02.jpg </idleImage>
		<idleImage> image/POPUP_LOADING_03.jpg </idleImage>
		<idleImage> image/POPUP_LOADING_04.jpg </idleImage>
		<idleImage> image/POPUP_LOADING_05.jpg </idleImage>
		<idleImage> image/POPUP_LOADING_06.jpg </idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		/scripts/image/sc_title.jpg
		</image>
		<text  offsetXPC=60 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		ShoutCast - Category
		</text>			
	    </mediaDisplay>

<channel>
	<title></title>
	<menu>main menu</menu>
<?php
$sLink = 'http://'.$_SERVER['HTTP_HOST'].'/scripts/php/sh_st.php';
$html = file_get_contents("http://www.shoutcast.com/sbin/newxml.phtml");
$videos = explode('<genre n', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('ame="', $video);
    $t2 = explode('"', $t1[1]);
    $gen = $t2[0];

    echo '<item>';
    echo '<title>'.$gen.'</title>';
    echo '<link>'.$sLink.'?gen='.$gen.'</link>';	
    echo '</item>';
}


?>
</channel>
</rss>