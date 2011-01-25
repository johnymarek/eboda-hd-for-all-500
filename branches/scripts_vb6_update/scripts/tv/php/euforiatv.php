#!/usr/local/bin/Resource/www/cgi-bin/php
﻿<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1/cgi-bin";
?>
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
		EuforiaTV
		</text>			
</mediaDisplay>
<channel>
	<title>EuforiaTV</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
//http://www.euforia.tv/rubrici/72/cuisine/?p=2
if($page) {
    if($search) {
        $html = file_get_contents("http://www.euforia.tv/rubrici/72/cuisine/?p=".$page);
    } else {
    		
        $html = file_get_contents("http://www.euforia.tv/rubrici/72/cuisine/?p=".$page);
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents("http://www.euforia.tv/rubrici/72/cuisine/?p=".$page);
    } else {
        $html = file_get_contents("http://www.euforia.tv/rubrici/72/cuisine/?p=".$page);
    }
}
if($page > 1) { ?>

<item>
<?php
$sThisFile = 'http://127.0.0.1'.$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Previous Page</title>
<link><?php echo $url;?></link>
<media:thumbnail url="image/left.jpg" />
</item>


<?php } ?>

<?php

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$videos = explode('<div class="boxhead">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
  $t1 = explode('href="', $video);
  $t2 = explode('"', $t1[1]);
  $l = $t2[0];
  $t3 = explode(">",$t1[1]);
  $t4 = explode("<",$t3[1]);
  $title = trim($t4[0]);
	$link = str_replace(' ','%20',$link);
  $t1 = explode('img src="', $video);
  $t2 = explode('"', $t1[2]);
  $image = $t2[0];
  $image = str_replace(' ','%20',$image);
  if ((strpos($l, "cuisine") !== false) && (strpos($image,"ivm.inin.ro") !==false)) {
		$link = substr($image, 0, -7).".mp4";
		$link = str_replace("http://ivm.inin.ro/thumbs","http://vodh1.inin.ro",$link);
		
	  echo '<item>';
	  echo '<title>'.$title.'</title>';
	  echo '<link>'.$link.'</link>';
	  echo '<media:thumbnail url="'.$image.'" />';
	  echo '<enclosure type="video/flv" url="'.$link.'"/>';	
	  echo '</item>';
	  print "\n";
	}
}



?>

<item>
<?php
$sThisFile = 'http://127.0.0.1'.$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Next Page</title>
<link><?php echo $url;?></link>
<media:thumbnail url="image/right.jpg" />
</item>

</channel>
</rss>