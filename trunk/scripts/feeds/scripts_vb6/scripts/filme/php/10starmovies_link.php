#!/usr/local/bin/Resource/www/cgi-bin/php
<?php
$query = $_GET["file"];
$queryarr = explode(",",$query);
$episodeLink = $queryarr[0];
$serieTitle = urldecode($queryarr[1]);
$pg = preg_replace('/[^A-Za-z0-9_]/','_',$serieTitle);
?>
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
	showHeader="no"
	showDefaultInfo="no"
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
  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="18" fontSize="24" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>
  	<text  redraw="yes" align="center" offsetXPC="0" offsetYPC="90" widthPC="100" heightPC="8" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
    Apasati 2 pentru download
		</text>
<onUserInput>
	userInput = currentUserInput();

	if( userInput == "two")
	{
		topUrl = "http://127.0.0.1/cgi-bin/scripts/util/download.cgi?link=" + getItemInfo(getFocusItemIndex(),"download") + ";name=" + getItemInfo(getFocusItemIndex(),"name");
		dlok = loadXMLFile(topUrl);
	}

</onUserInput>
</mediaDisplay>
<destination>
	<link>http://127.0.0.1/cgi-bin/scripts/util/level.php
	</link>
</destination>
<channel>
<?php
echo "<title>".$serieTitle."</title>"
;
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
$host = "http://127.0.0.1/cgi-bin";
$baseurl = "http://127.0.0.1/cgi-bin/translate?stream,Content-type:video/x-flv,";
$content = file_get_contents($episodeLink);
$newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
$input = str_replace($newlines, "", $content);
//http://www.watch-24-online-free.com/play_source.php?id=200703026
$videos = explode("javascript:load_source_new(",$input);
preg_match("/<h5>Available Sources<\/h5>(.*)<\/div>/U", $input, $div);
$videos = explode("javascript:load_source_new(",$div[1]);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1=explode(",",$video);
  $id=$t1[0];
  //echo substr($episodeLink,0,strrpos($episodeLink,"/"))."/play_source.php?id=".$id."<br>";
  if (strpos($video,"loombo") !==false) {
    $source="lombo";
    //echo strlen("abqslstdykqarkrf7ujlfpasyigtt5agpljbqqp4lchte3xey6lpcfls");
    $html = file_get_contents(substr($episodeLink,0,strrpos($episodeLink,"/")) . "/play_source.php?id=".$id);
    $t1=explode('href="',$html);
    $t2=explode('"',$t1[1]);
    $link=$t2[0];
    $embed=substr(strrchr($link,"/"),1);
    $link = "http://loombo.com/embed-".$embed."-640x318.html";
    $h = file_get_contents($link);
    $h = str_between($h,"eval(function","</script>");
    $a = explode("|",$h);
    for ($i=1;$i<60;$i++) {
      if ((strlen($a[$i]) >= 50) && (strpos($a[$i],"_") === false)) {
           $hash = $a[$i];
           break;
      }
    }
    if ($hash <> "") {
      $link="http://82.199.140.10:182/d/".$hash."/video.avi";
      $link1=$baseurl.$link;
     echo '
     <item>
     <title>loombo link</title>
     <name>'.$pg.'.avi</name>
     <download>'.$link.'</download>
	 <link>'.$link1.'</link>
     <enclosure type="video/flv" url="'.$link1.'"/>
     </item>
     ';
    }
    //http://loombo.com/soa2808si1qs
    //http://loombo.com/embed-soa2808si1qs-640x318.html
    //http://82.199.140.10:182/d/abqslstdykqarkrf7ujlfpasyigtt5agpljbqqp4lchte3xey6lpcfls/video.avi
  } elseif (strpos($video,"megavideo") !==false) {
    $source="megavideo";
    $html = file_get_contents(substr($episodeLink,0,strrpos($episodeLink,"/")) . "/play_source.php?id=".$id);
    $t1=explode('href="',$html);
    $t2=explode('"',$t1[1]);
    $megavideo_id=$t2[0];
    $t1=explode("v=",$megavideo_id);
    $mega_id=$t1[1];
    $link1 = "http://127.0.0.1/cgi-bin/scripts/php1/mega.php?id=".$mega_id;
   	echo '
    <item>
   	<title>megavideo link-'.$mega_id.'-(click for links)</title>
   	<link>'.$link1.'</link>
   	</item>
    ';
  } elseif (strpos($video,"stagevu") !==false) {
    $source="stagevu";
    $html = file_get_contents(substr($episodeLink,0,strrpos($episodeLink,"/")) . "/play_source.php?id=".$id);
    $t1=explode('href="',$html);
    $t2=explode('"',$t1[1]);
    $h=$t2[0];
    $h=file_get_contents($h);
    $link = str_between($h,'param name="src" value="','"');
    $link1=$baseurl.$link;
     echo '
     <item>
     <title>stagevu link</title>
     <name>'.$pg.'.avi</name>
     <download>'.$link.'</download>
	 <link>'.$link1.'</link>
     <enclosure type="video/flv" url="'.$link1.'"/>
     </item>
     ';
  } elseif (strpos($video,"zshare1") !==false) {
    $source="zshare";
    $html = file_get_contents(substr($episodeLink,0,strrpos($episodeLink,"/")) . "/play_source.php?id=".$id);
    $t1=explode('href="',$html);
    $t2=explode('"',$t1[1]);
    $h=$t2[0];
    $h=file_get_contents($h);
    $l=str_between($h,'<iframe src="','"');
    $h=file_get_contents($l);
    $link = str_between($h,'file: "','"');
    $link1=$baseurl.$link;
     echo '
     <item>
     <title>zshare link</title>
     <name>'.$pg.'.avi</name>
     <download>'.$link.'</download>
	 <link>'.$link1.'</link>
     <enclosure type="video/flv" url="'.$link1.'"/>
     </item>
     ';
  }
}
// utils
   echo '
   <item>
   <title>Download Manager</title>
   <link>http://127.0.0.1/cgi-bin/scripts/util/level.php</link>
   </item>
   ';
    $link = "http://127.0.0.1/cgi-bin/scripts/util/util1.cgi";
  	echo '
    <item>
  	<title>Stop download</title>
  	<link>'.$link.'</link>
  	<enclosure type="text/txt" url="'.$link.'"/>
  	</item>
      ';
   $link = "http://127.0.0.1/cgi-bin/scripts/util/ren.php";
   echo '
   <item>
   <title>Redenumire fisiere descarcate</title>
   <link>'.$link.'</link>
   </item>
   ';
?>
</channel>
</rss>

