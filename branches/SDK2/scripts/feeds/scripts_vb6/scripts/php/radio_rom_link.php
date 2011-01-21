<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
	$id = $_GET["id"];
	$html = file_get_contents("http://www.shoutcast.com/sbin/tunein-station.pls?id=".$id);
	$url = trim(str_between($html,"File1=","Title1="));
	$title = trim(str_between($html,"Title1=","Length"));
	?>
<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<onEnter>
    setRefreshTime(200);
    startVideo = 1;
    }
</onEnter>

<onRefresh>
      if (startVideo == 1) {
          playItemURL("<?php echo $url; ?>", 0, "mediaDisplay", "previewWindow");
          setRefreshTime(-1);
          startVideo = 0;
      } 
</onRefresh>

<onExit>
      playItemURL(-1, 1);
      setRefreshTime(-1);
</onExit>
	<mediaDisplay name="threePartsView" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="10" idleImageHeightPC="16">
	<idleImage>image/POPUP_LOADING_01.jpg</idleImage>
	<idleImage>image/POPUP_LOADING_02.jpg</idleImage>
	<idleImage>image/POPUP_LOADING_03.jpg</idleImage>     
	<idleImage>image/POPUP_LOADING_04.jpg</idleImage>
	<idleImage>image/POPUP_LOADING_05.jpg</idleImage>
	<idleImage>image/POPUP_LOADING_06.jpg</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		Posturi radio Romania
		</text>	
<!-- X -- Y || -->
    <previewWindow windowColor=8:8:15 offsetXPC=45 offsetYPC=25 widthPC=1 heightPC=1>
    </previewWindow>
	<text offsetXPC=5 offsetYPC=20 widthPC=90 fontSize=18 heightPC=10 lines=2 tailDots=yes backgroundColor=-1:-1:-1 foregroundColor=200:200:200>
	 <?php echo $title; ?>
	</text>
<onUserInput>
input = currentUserInput();
ret = "false";
if (input == "stop" || input == "setup" || input == "guide")
{
    playItemURL(-1, 1);
    setRefreshTime(-1);
	postMessage("return");
	if (input == "setup")
		postMessage("setup");
	else
		postMessage("guide");
	ret = "true";
}
ret;
</onUserInput>
</mediaDisplay>
<channel>
	<title>Posturi radio romania</title>
	<link></link>
</channel>

</rss>