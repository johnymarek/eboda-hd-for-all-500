<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
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
		podcastalley
		</text>			
</mediaDisplay>
<channel>
	<title>podcastalley</title>
	<menu>main menu</menu>

<?php


$html = file_get_contents("http://www.podcastalley.com/index.php");


$videos = explode('<option', $html);
unset($videos[0]);
$videos = array_values($videos);
$img = "/scripts/clip/image/podcastalley.gif";
foreach($videos as $video) {
    $t1 = explode('value="', $video);
    $t2 = explode('"', $t1[1]);
    $link =$t2[0];
    
    $t3 = explode('">', $t1[1]);
    $t4 = explode('<', $t3[1]);
    $title =$t4[0];
    if ($link <> "#") {
    	$link = "http://www.podcastalley.com/".$link;
			$link=$host."/scripts/clip/php/podcastalley.php?query=,".$link;

	    echo '
	    <item>
	    <title>'.$title.'</title>
	    <link>'.$link.'</link>
	    <media:thumbnail url="'.$img.'" />
	    </item>
	    ';
	  }
}
?>

</channel>
</rss>
