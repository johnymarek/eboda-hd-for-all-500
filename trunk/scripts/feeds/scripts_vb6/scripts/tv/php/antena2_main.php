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
		Antena2 - Emisiuni
		</text>			
</mediaDisplay>
  <channel>

    <title>Antena2 - Emisiuni</title>
<?php
$html = file_get_contents("http://www.antena2.tv/emisiuni");
$image = "/scripts/tv/image/antena2.jpg";
$videos = explode('<h2><a href="', $html);
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
  $t1 = explode('"', $video);
  $link = "http://www.antena2.tv".$t1[0];
  $link = str_replace("emisiuni","arhiva",$link);
	$link = $host."/scripts/tv/php/antena2.php?query=1,".$link;
  $t1 = explode('title="', $video);
  $t2 = explode('"', $t1[1]);
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