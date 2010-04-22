<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="10" idleImageHeightPC="16">
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
		/tmp/hdd/volumes/HDD1/scripts/image/sc_title.jpg
		</image>
		<text  offsetXPC=60 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		ShoutCast - Station
		</text>			
	    </mediaDisplay>

<channel>
	<title></title>
	<menu>main menu</menu>
	<?php
	$id = $_GET["id"];
	$html = file_get_contents("http://www.shoutcast.com/sbin/tunein-station.pls?id=".$id);
//	echo $html;
//	ereg ("File",$html,$videos);
	$videos = explode('File', $html);
echo $videos[1];
unset($videos[0]);
$videos = array_values($videos);
$n = 1;
foreach($videos as $video) {
//	echo 'File'.$n.'=';
    $t1 = explode($n.'=', $video);
    $t2 = explode('Title', $t1[1]);
    $id = $t2[0];
    $t1 = explode('Title', $video);
    $t2 = explode('Length', $t1[1]);
    $title = $t2[0];
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>http://127.0.0.1:8081/scripts/php/magic.php?id='.$id.'</link>';
    echo '<media:thumbnail url="/tmp/hdd/volumes/HDD1/scripts/image/rss1.jpg" />';	
    echo '</item>';
    $n = $n + 1;
  }
?>
	</channel>
	</rss>