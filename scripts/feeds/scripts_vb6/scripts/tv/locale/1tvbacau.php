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
		1tvbacau.ro
		</text>			
</mediaDisplay>
<channel>
	<title>1tvbacau.ro</title>
	<menu>main menu</menu>

<?php
$html = file_get_contents("http://www.1tvbacau.ro/video/");
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
function ascii2entities($string){
    for($i=128;$i<=255;$i++){
        $entity = htmlentities(chr($i), ENT_QUOTES, 'cp1252');
        $temp = substr($entity, 0, 1);
        $temp .= substr($entity, -1, 1);
        if ($temp != '&;'){
            $string = str_replace(chr($i), '', $string);
        }
        else{
            $string = str_replace(chr($i), $entity, $string);
        }
    }
    return $string;
}
$videos = explode('<div class="my_wideo_other_link">', $html);

unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = htmlentities($t2[0]);
    
    $image = "/scripts/tv/image/1tvbacau.jpg";

    //$title = iconv("ISO-8859-2","UTF-8",trim(str_between($video,'">','</a>')));
    //$title = utf8_encode(trim(str_between($video,'">','</a>')));
     $title = htmlentities(trim(str_between($video,'">','</a>')));
     $title = str_replace("&ordm;","s",$title);
     $title = str_replace("&Ordm;","S",$title);
     $title = str_replace("&thorn;","t",$title);
     $title = str_replace("&Thorn;","T",$title);
     $title = str_replace("&icirc;","i",$title);
     $title = str_replace("&Icirc;","I",$title);
     $title = str_replace("&atilde;","a",$title);
     $title = str_replace("&Atilde;","I",$title);
     $title = str_replace("&ordf;","S",$title);
     $title = str_replace("&acirc;","a",$title);
     $title = str_replace("&Acirc;","A",$title);
     //$title = "titlu...";
		$link = $host.'/scripts/tv/locale/1tvbacau_link.php?file='.$link;

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