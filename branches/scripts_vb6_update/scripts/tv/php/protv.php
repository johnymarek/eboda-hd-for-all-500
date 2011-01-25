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
		ProTV - Videoteca
		</text>			
</mediaDisplay>
<channel>
	<title>ProTV - Videoteca</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
//http://www.protv.ro/multimedia/happy-hour
//http://www.protv.ro/multimedia/happy-hour/pagina-1#paginare
if($page) {
	$html = file_get_contents($search."/pagina-".$page."#paginare");
} else {
  $page = 1;
	$html = file_get_contents($search);
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
<pubDate></pubDate>
<media:thumbnail url="/scripts//scripts/image/left.jpg" />
</item>


<?php } ?>
<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$videos = explode('a class="videoItem"', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
	$t1 = explode('href="', $video);
	$t2 = explode('"', $t1[1]);
	$link = $t2[0];
	$link = str_replace(' ','%20',$link);
	$link = str_replace('[','%5B',$link);
	$link = str_replace(']','%5D',$link); 
	 
	$t1 = explode('src="', $video);
	$t2 = explode('"', $t1[1]);
	$image = $t2[0];
	
	$t1 = explode('src="', $video);
	$t2 = explode('>', $t1[2]);
	$t3 = explode('<',$t2[1]);
	$title = trim($t3[0]);
	$data = str_between($video,'<div class="overData">','</div>');
	if (strpos($image,"web3.protv.ro") !== false) {
		$link = $host."/scripts/tv/php/protv_link.php?file=".$link;
    echo '
    <item>
    <title>'.$title.'</title>
    <link>'.$link.'</link>
    <pubDate>'.$data.'</pubDate>
    <media:thumbnail url="'.$image.'" />
    </item>';
  } elseif (strpos($image,"assets.sport.ro") !== false) {
  	//http://assets.sport.ro/assets/procinema/2010/10/30/videos/9806/thumb2_csid-moda-ani-50.jpg
  	$link1 = str_replace("thumb2_","",$image);
  	$link1 = str_replace(".jpg",".flv",$link1);
  	$link1 = str_replace("-","_",$link1);
  	$AgetHeaders = @get_headers($link1);
		if (preg_match("|200|", $AgetHeaders[0])) {
	    echo '
	    <item>
	    <title>'.$title.'</title>
	    <link>'.$link1.'</link>
	    <pubDate>'.$data.'</pubDate>
	    <media:thumbnail url="'.$image.'" />
	    <enclosure type="video/flv" url="'.$link1.'"/>
	    </item>';
  } else {
			$link = $host."/scripts/tv/php/protv_link.php?file=".$link;
	    echo '
	    <item>
	    <title>'.$title.'</title>
	    <link>'.$link.'</link>
	    <pubDate>'.$data.'</pubDate>
	    <media:thumbnail url="'.$image.'" />
	    </item>';
  }  	
  }
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
<pubDate></pubDate>
<media:thumbnail url="/scripts//scripts/image/right.jpg" />
</item>

</channel>
</rss>