<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
<rss version="2.0" xmlns:media="http://purl.org/dc/elements/1.1/" xmlns:dc="http://purl.org/dc/elements/1.1/">
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
<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$html = file_get_contents("http://www.protv.ro/video/");
$image = "/scripts/tv/image/protv.jpg";
$html = str_between($html,'<div class="videos">','<div class="rightVideos">');
$videos = explode('href="', $html);
unset($videos[0]);
$videos = array_values($videos);
//http://assets.sport.ro/assets/protv/2010/10/29/videos/22/teaser_happy_hour_1080p-transfer_ro-29oct-1050cd.mov.flv
//http://web3.protv.ro/assets/protv/hh/episodes/muzica-happy-29-octombrie-2/muzica-happy-29-octombrie-2/c1.flv
//http://web3.protv.ro/assets/protv/hh/episodes/muzica-happy-29-octombrie-2/muzica-happy-29-octombrie-2/thumbs/c1.jpg
foreach($videos as $video) {
  $t1 = explode('"', $video);
  $link = $t1[0];
	$link = $host."/scripts/tv/php/protv.php?query=1,".$link;
  $t1 = explode('>', $video);
  $t2 = explode('<', $t1[1]);
  $title = trim($t2[0]);
  echo '
  <item>
  <title>'.$title.'</title>
  <link>'.$link.'</link>
  <media:thumbnail url="'.$image.'" />
  </item>
  ';
}
?>
</channel>
</rss>
