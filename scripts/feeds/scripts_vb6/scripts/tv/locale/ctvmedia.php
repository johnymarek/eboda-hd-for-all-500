<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
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
		ctvmedia - Constanta
		</text>			
</mediaDisplay>
<channel>
	<title>ctvmedia.ro</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

if ($page > 1) {
	$page1 = 5* ($page - 1);
	$html = file_get_contents("http://www.ctvmedia.ro/index.php?limitstart=".$page1);
} else {
	$page = 1;
	$html = file_get_contents("http://www.ctvmedia.ro/index.php");
}
if($page > 1) { ?>

<item>
<?php
$sThisFile = 'http://127.0.0.1:82'.$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Previous Page</title>
<link><?php echo $url;?></link>
<media:thumbnail url="/scripts/image/left.jpg" />
</item>


<?php } ?>

<?php

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$image = "/scripts/tv/image/ctvmedia.jpg";
$videos = explode('<div class="contentpaneopen">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
		$link = str_between($video,'value="file=','&');
		$link = str_replace(" ","%20",$link);
    $title = trim(str_between($video,'<h2 class="contentheading">','</h2>'));
		$data =  trim(str_between($video,'<span class="createdate">','</span>'));
	
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<pubDate>'.$data.'</pubDate>';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
    print "\n";
}



?>

<item>
<?php
$sThisFile = 'http://127.0.0.1:82'.$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Next Page</title>
<link><?php echo $url;?></link>
<media:thumbnail url="/scripts/image/right.jpg" />
</item>

</channel>
</rss>
