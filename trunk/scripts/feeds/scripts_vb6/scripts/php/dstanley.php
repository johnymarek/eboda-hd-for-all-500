<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $t = $queryArr[0];
   $link = $queryArr[1];
}
?>
	<mediaDisplay name="threePartsView" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="10" idleImageHeightPC="16">
	<idleImage>image/POPUP_LOADING_01.jpg</idleImage>
	<idleImage>image/POPUP_LOADING_02.jpg</idleImage>
	<idleImage>image/POPUP_LOADING_03.jpg</idleImage>     
	<idleImage>image/POPUP_LOADING_04.jpg</idleImage>
	<idleImage>image/POPUP_LOADING_05.jpg</idleImage>
	<idleImage>image/POPUP_LOADING_06.jpg</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		<?php echo $t; ?>
		</text>	
	</mediaDisplay>
<channel>
	<title>dstanley</title>
	<menu>main menu</menu>


<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$image = "/tmp/hdd/volumes/HDD1/scripts/image/mv_logo.gif";
$link = str_replace(' ','%20',$link);
$html = file_get_contents($link);
if (stripos($html,"mv_logo.gif") !== false) {
	$html = str_between($html, "mv_logo.gif", "<div class='post-footer'>");
} else {
	$html = str_between($html, "MV.gif", "<div class='post-footer'>");
}
//echo $html;
$ts = explode('<a href="http://www.megavideo.com', $html);
unset($ts[0]);
$ts = array_values($ts);
$n=0;
$title[]="first";
foreach($ts as $t) {
//	if ((stripos($video,"<b>")=== false) && (stripos($video,"megavideo")=== false)) {
		$t1=str_between($t,"<br />","<br />");
		if (stripos($t1,"<") === false) {
    	$title[] = $t1;
    } else {
    	$t2=strstr($title, '>');
    	if ($t2 <> "") {
    	$title[] = $t2;
    } else {
    	$title[] = "Next";
    }
    }
  }
//  }
$videos = explode("<br />", $html);
unset($videos[0]);
$videos = array_values($videos);
$n=0;
foreach($videos as $video) {
	if (stripos($video,"megavideo")!== false) {
		$t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = substr($t2[0], -8);
		//$link = "http://127.0.0.1:82/scripts/php/megavideo.php?file=".$link;
		//$link = "http://estosesale.com/megavideo.php?file=".$link;
		$link = "http://estosesale.com/megavideotito3.php?video_id=".$link;
    echo '<item>';
    echo '<title>'.$title[$n].'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
    print "\n";
    $n=$n+1;
  }
  }
  
?>


</channel>
</rss>