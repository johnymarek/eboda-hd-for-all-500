<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<mediaDisplay name="threePartsView" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="20" idleImageHeightPC="26">
	<idleImage>/scripts/image/busy1.png</idleImage>
	<idleImage>/scripts/image/busy2.png</idleImage>
	<idleImage>/scripts/image/busy3.png</idleImage>     
	<idleImage>/scripts/image/busy4.png</idleImage>
	<idleImage>/scripts/image/busy5.png</idleImage>
	<idleImage>/scripts/image/busy06.jpg</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		www.cancan.ro
		</text>	
	</mediaDisplay>
<channel>
	<title>www.cancan.ro</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

if($page) {
    if($search) {
        $html = file_get_contents($search);
    } else {
        $html = file_get_contents($search);
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents($search);
    } else {
        $html = file_get_contents($search);
    }
}


if($page > 1) { ?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Previous Page</title>
<link><?php echo $url;?></link><media:thumbnail url="/scripts/image/left.jpg" />
</item>


<?php } ?>

<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
//$v_id = str_between($html, '<ul class="video-tag-list">', '</ul>');
//echo $html;
$videos = explode('<div class="item"', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('change_main_galery(', $video);
    $t2 = explode(',', $t1[1]);
    $link1 = $t2[0];
    $link = "http://www.cancan.ro/config/video/".$link1.".xml";
//echo $link;
    $t1 = explode("src='", $video);
    $t2 = explode("'", $t1[1]);
    $image = "http://www.cancan.ro".$t2[0];

    $t1 = explode("alt='", $video);
    $t2 = explode("'", $t1[1]);
    $title = $t2[0];

//$pos1 = stripos($link, 'source=');
//if ($pos1 === false) {
if ($link1 <> "") {
    $html = file_get_contents($link);
    $link = urldecode(str_between($html, '<file>', '</file>'));
//if($link=="") {
//	$link = str_between($html, "flashvars.video_url = '", "'");
//}
    //$html = file_get_contents($link);
    //$link = str_between($html, '<flv_url>', '</flv_url>');
if ($link <> "") {
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
}
}
}
?>

</channel>
</rss>