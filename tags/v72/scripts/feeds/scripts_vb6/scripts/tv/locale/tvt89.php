﻿<?php echo "<?xml version='1.0' ?>"; ?>
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
		tvt89
		</text>			
</mediaDisplay>
<channel>
	<title>tvt89</title>
	<menu>main menu</menu>

<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
if($page) {
	$page1=10*($page-1);
    if($search) {
        $html = file_get_contents("http://tvt89.bridgeman.ro/video.php?start=".$page."&tip=1");
    } else {
        $html = file_get_contents("http://tvt89.bridgeman.ro/video.php?start=".$page."&tip=1");
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents("http://tvt89.bridgeman.ro/video.php?tip=1");
    } else {
        $html = file_get_contents("http://tvt89.bridgeman.ro/video.php?tip=1");
    }
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

$videos = explode('<td class="poza_video" valign="top">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
	    $t1 = explode('href="', $video);
	    $t2 = explode('"', $t1[1]);
			$link = "http://tvt89.bridgeman.ro/".$t2[0];
		
    	$t1 = explode('src="', $video);
    	$t2 = explode('"', $t1[1]);
    	$image = "http://tvt89.bridgeman.ro/".$t2[0];

    	$title = str_between($video,'<td class="nume_emisiune">','</td>');
    	$data = str_between($video,'<td class="data_emisiune">','</td>');
    	
			$html = file_get_contents($link);
			$link = "http://tvt89.bridgeman.ro/".str_between($html,"file=","&");
			$link = str_replace(' ','%20',$link);
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<pubDate>'.$data.'</pubDate>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
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