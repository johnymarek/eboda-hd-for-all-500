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
<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

/*
http://gdata.youtube.com/feeds/api/users/nba/uploads?&start-index=1&max-results=25&v=2
*/
if(!$page) {
    $page = 1;
}
$p=25*($page-1)+1;
$link="http://gdata.youtube.com/feeds/api/users/".$search."/uploads?start-index=".$p."&max-results=25&v=2";
$link=str_replace("&","&amp;",$link);
$html = file_get_contents($link);
echo '
	<channel>
		<title>Uploads by '.$search.'</title>
		<menu>main menu</menu>
		';
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
$videos = explode('<entry>', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
	$id = str_between($video,"<id>http://gdata.youtube.com/feeds/api/videos/","</id>");
	$title = str_between($video,"<title type='text'>","</title>");
	$data = str_between($video,"<updated>","</updated>");
	$data = str_replace("T"," ",$data);
	$data = str_replace("Z","",$data);
	$image = "http://i.ytimg.com/vi/".$id."/2.jpg";
	$link = "http://127.0.0.1:83/cgi-bin/translate?stream,HD:1,http://www.youtube.com/watch?v=".$id;
	echo '
	<item>
	<title>'.$title.'</title>
	<link>'.$link.'</link>
	<pubDate>'.$data.'</pubDate>
	<media:thumbnail url="'.$image.'" />
	<enclosure type="video/flv" url="'.$link.'"/>
	</item>
	';
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