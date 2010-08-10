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
		Reuters
		</text>			
</mediaDisplay>
<channel>
	<title>Reuters</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

if($page) {
	$page1=$page-1;
    if($search) {
        $html = file_get_contents("http://www.reuters.com/assets/videoTab?videoChannel=".$search);
    } else {
        $html = file_get_contents("http://www.reuters.com/assets/videoTab?videoChannel=".$search);
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents("http://www.reuters.com/assets/videoTab?videoChannel=".$search);
    } else {
        $html = file_get_contents("http://www.reuters.com/assets/videoTab?videoChannel=".$search);
    }
}

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
//$v_id = str_between($html, '<ul class="video-tag-list">', '</ul>');

$videos = explode('<div class="feature">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.reuters.com".$t2[0];

//$pos1 = stripos($link, 'source=');
//if ($pos1 === false) {
//var RTR_VideoTitle =  "

    $html = file_get_contents($link);
    $title = str_between($html, 'var RTR_VideoTitle =  "', '"');
    $link = urldecode(str_between($html, "mpeg': '", "'"));
    $pos = stripos($link,'MP4');
    if ($pos === false) {
    	$link = urldecode(str_between($html, "flv': '", "'"));
    }
    $image = str_between($html, 'thumbnail": "', '"');
    //thumbnail": "
//if($link=="") {
//	$link = str_between($html, "flashvars.video_url = '", "'");
//}
    //$html = file_get_contents($link);
    //$link = str_between($html, '<flv_url>', '</flv_url>');

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
}


?>

</channel>
</rss>