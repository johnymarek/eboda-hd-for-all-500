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
	idleImageWidthPC="10"
	idleImageHeightPC="10">
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
		Link
		</text>			
<onUserInput>
	userInput = currentUserInput();

	if( userInput == "two")
	{
		topUrl = "http://127.0.0.1:82/scripts/util/download.cgi?link=" + getItemInfo(getFocusItemIndex(),"download") + ";name=" + getItemInfo(getFocusItemIndex(),"name");
		dlok = loadXMLFile(topUrl);
	}

</onUserInput>
</mediaDisplay>
<destination>
	<link>http://127.0.0.1:82/scripts/util/level.php
	</link>
</destination>
<channel>
	<title>link</title>
	<menu>main menu</menu>
<?php
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
$id = $_GET["id"];
$lastlink = "abc";
$baseurl = "http://127.0.0.1:82/scripts/cgi-bin/translate?stream,Content-type:video/x-flv,";
	 //$link = "http://estosesale.com/mvpremiumoriginal.php?video_id=".$id;
	 $link = "http://titooo.net23.net/megavideo/mvpremiumoriginal.php?video_id=".$id;
   $title = "megavideo (premium) - file=".$id;
   if (($link <> "") && strcmp($link,$lastlink)) {
   		$link1 = $baseurl.$link;
        $ext = "flv";
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<link>'.$link1.'</link>';
    	echo '<name>'.$id.'.'.$ext.'</name>';
    	echo '<download>'.$link.'</download>';
    	echo '<media:thumbnail url="/scripts/image/movies.png"/>';
    	echo '<enclosure type="video/flv" url="'.$link1.'"/>';
    	echo '</item>';
    print "\n";
    $lastlink = $link;
  }
	 $title = "megavideo (limit to 71 min.) - file=".$id;
   $link = "http://127.0.0.1:82/scripts/php1/megavideo.php?video_id=".$id;
   if (($link <> "") && strcmp($link,$lastlink)) {  
   		$link1 = $baseurl.$link;
        $ext = "flv";
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<link>'.$link1.'</link>';
    	echo '<name>'.$id.'.'.$ext.'</name>';
    	echo '<download>'.$link.'</download>';
    	echo '<media:thumbnail url="/scripts/image/movies.png"/>';
    	echo '<enclosure type="video/flv" url="'.$link1.'"/>';	
    	echo '</item>';
    print "\n";
    $lastlink = $link;
  }
$post ="url=http://www.megavideo.com/?v=".$id;
if (function_exists('curl_init')) {
  $Curl_Session = curl_init('http://www.megavideonotimelimit.com/Streamer/');
  curl_setopt ($Curl_Session, CURLOPT_POST, 1);
  curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, $post);
  curl_setopt ($Curl_Session, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($Curl_Session, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS
  curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  $Rec_Data = curl_exec ($Curl_Session);
  curl_close ($Curl_Session);
} else {  // pseudo curl
  exec ("rm -f /tmp/mega.txt");
  $ua='"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; ro; rv:1.9.1) Gecko/20090624 Firefox/3.5 GTB7.1"';
  $post='"'.$post.'"';
  $ref='"Referer: http://www.megavideonotimelimit.com/Streamer/"';
  $app='"Content-Type: application/x-www-form-urlencoded"';
  $exec = "/sbin/wget -q --header ".$ua." --header ".$ref." --header ".$app." --post-data ".$post." -O /tmp/mega.txt http://www.megavideonotimelimit.com/Streamer/";
  exec ($exec);
  $Rec_Data = file_get_contents("/tmp/mega.txt");
}
// echo $Rec_Data;
$url = urldecode(str_between($Rec_Data,'flashvars="file=','&'));
$url = str_replace("%2F","/",$url);
$url = str_replace("%3A",":",$url);
$url = str_replace("%3F","?",$url);
$url = str_replace("%3D","=",$url);
$link = str_replace("%26","&",$url);
$title = "mmegavideo - premium 2 - file=".$id;
   if (($link <> "") && strcmp($link,$lastlink)) {
   		$link1 = $baseurl.$link;
        $ext = "flv";
    	echo '<item>';
    	echo '<title>'.$title.'</title>';
    	echo '<link>'.$link1.'</link>';
    	echo '<name>'.$id.'.'.$ext.'</name>';
    	echo '<download>'.$link.'</download>';
    	echo '<media:thumbnail url="/scripts/image/movies.png"/>';
    	echo '<enclosure type="video/flv" url="'.$link1.'"/>';
    	echo '</item>';
    print "\n";
    $lastlink = $link;
    }

// utils
    $link = "http://127.0.0.1:82/scripts/util/util1.cgi";
  	echo '
    <item>
  	<title>Stop download</title>
  	<link>'.$link.'</link>
  	<enclosure type="text/txt" url="'.$link.'"/>
  	</item>
      ';
   $link = "http://127.0.0.1:82/scripts/util/ren.php";
   echo '
   <item>
   <title>Redenumire fisiere descarcate</title>
   <link>'.$link.'</link>
   </item>
   ';
   echo '
   <item>
   <title>Download Manager</title>
   <link>http://127.0.0.1:82/scripts/util/level.php</link>
   </item>
   ';
?>

</channel>
</rss>
