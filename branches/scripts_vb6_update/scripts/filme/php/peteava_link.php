<?php echo "<?xml version='1.0' encoding='UTF8' ?>"; ?>
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
 	idleImageWidthPC="10"
 	idleImageHeightPC="10"
>
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
<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$baseurl = "http://127.0.0.1:83/cgi-bin/translate?stream,Content-type:video/x-flv,";
$link = $_GET["file"];
$t=explode(",",$link);
$link = $t1[0];
$pg = urldecode($t1[1]);
if ($pg == "") {
   $pg = "peteava.ro - link";
}
echo "<title>".$pg."</title>";
$html = file_get_contents($link);
$id = str_between($html,"stream.php&file=","&");
$link="http://content.peteava.ro/video/".$id;
$server = str_between($link,"http://","/");
$title = $server." - ".$id; 
$link = $baseurl.$link;
echo '
<item>
<title>Link</title>
<link>'.$link.'</link>
<enclosure type="video/flv" url="'.$link.'"/>	
</item>
';
$link = "http://127.0.0.1:82/scripts/util/util1.cgi";
echo '<item>';
echo '<title>Stop download</title>';
echo '<link>'.$link.'</link>';
echo '<enclosure type="text/txt" url="'.$link.'"/>';
echo '</item>';
print "\n";

$link = "http://127.0.0.1:82/scripts/util/ren.php";
echo '<item>';
echo '<title>Redenumire fisiere descarcate</title>';
echo '<link>'.$link.'</link>';
echo '</item>';
print "\n";
?>
</channel>
</rss>