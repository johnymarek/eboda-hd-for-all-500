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
		www.sportgioco.it
		</text>			
</mediaDisplay>
<channel>
	<title>www.sportgioco.it</title>
	<menu>main menu</menu>


<?php

function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
$html = file_get_contents("http://www.sportgioco.it/calcio/highlights.php");
$image = "/scripts/tv/image/sportgioco.jpg";
$videos = explode('<tr>', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
		$link = $t2[0];
		$data = str_between($video,'<td class="tdLight3" style="text-align:center" width="15%">','</td>');
		$title = str_between($video,'target="_blank">','<');
		if (strpos($link, "youtube") !== false) {
			if (strpos($link, "&") === false) {
			$v_id = substr(strrchr($link, "="), 1);
			$link = "http://127.0.0.1:82/scripts/cgi-bin/translate?stream,HD:1,http://www.youtube.com/watch?v=".$v_id;
		} else {
			$v_id = str_between($link,'v=','&');
			$link = "http://127.0.0.1:82/scripts/cgi-bin/translate?stream,HD:1,http://www.youtube.com/watch?v=".$v_id;
		}
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<pubDate>'.$data.'</pubDate>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '<enclosure type="video/flv" url="'.$link.'"/>';    		
    	echo '</item>';
    	print "\n";
	}
		if (strpos($link, "sapo.pt") !== false) {
			$v_id = substr(strrchr($link, "/"), 1);
			$link = "http://rd3.videos.sapo.pt/".$v_id."/mov/1" ;
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<pubDate>'.$data.'</pubDate>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '<enclosure type="video/flv" url="'.$link.'"/>';    		
    	echo '</item>';
    	print "\n";
		}
//http://dailymotion.virgilio.it/video/xf1qq7_bir-vs-eve_sport
		if (strpos($link, "dailymotion") !== false) {
			$link="http://127.0.0.1:82/scripts/clip/php/dm_link.php?file=".$link;
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<pubDate>'.$data.'</pubDate>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';    		
    	echo '</item>';
    	print "\n";
		}
//http://rutube.ru/tracks/3638959.html?v=d0521f5940a15fec648885287422fd90
//http://vids.myspace.com/index.cfm?fuseaction=vids.individual&videoid=106711464
		if (strpos($link, "vids.myspace.com") !== false) {
			$suf1 = "/vid.mp4";
			$suf2 = "/vid.flv";
			$h1 = file_get_contents($link);
			$link = str_between($h1,'<link rel="image_src" href="','"');
			$link = str_replace('thumb1_','',$link);
			$link = str_replace('thumb2_','',$link);
			$link = str_replace('.jpg','',$link);
			$part = substr($link,34);
			$link = "http://l3-hl1.videos02.myspacecdn.com".$part.$suf1; //mp4
			$AgetHeaders = @get_headers($link);
			if (!preg_match("|200|", $AgetHeaders[0])) {
				$link = "http://l3-hl1.videos02.myspacecdn.com".$part.$suf2; //flv	
				$AgetHeaders = @get_headers($link);
				if (!preg_match("|200|", $AgetHeaders[0])) {
					$link = "http://l3-hl1xl.myspacecdn.cust.footprint.net".$part.$suf1; //mp4
					$AgetHeaders = @get_headers($link);
					if (!preg_match("|200|", $AgetHeaders[0])) {
						$link = "http://l3-hl1xl.myspacecdn.cust.footprint.net".$part.$suf2; //flv
						$AgetHeaders = @get_headers($link);
						if (!preg_match("|200|", $AgetHeaders[0])) {
							$link = "";
						}
					}
				}
			}
	if ($link <> "") {
			echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<link>'.$link.'</link>';
    	echo '<media:thumbnail url="'.$image.'" />';
    	echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    	echo '</item>';
    	print "\n";
    }
		}
//http://www.footytube.com/video/terek-groznyi-tom-tomsk-oct02-58160
//http://farm12.serve.kwcdn.kz/v/yl6b5bazhk0e/?secret=pGFDT%2F0M263EL1ZJNJloJw%3D
}


?>

</channel>
</rss>
