#!/usr/local/bin/Resource/www/cgi-bin/php
<?php
error_reporting(0);
$filelink=$_ENV["QUERY_STRING"];
$t1=explode(",",$filelink);
$filelink = urldecode($t1[0]);
$filelink = str_replace("*",",",$filelink);
$filelink = str_replace("@","&",$filelink); //seriale.subtitrate.info
$pg = urldecode($t1[1]);
if ($pg == "") {
   $pg_title = "Link";
} else {
  $pg_title = $pg;
  $pg = preg_replace('/[^A-Za-z0-9_]/','_',$pg);
}
$titledownload=$pg;
$onlinemoca=$t1[2];
//play movie
if (file_exists("/tmp/usbmounts/sda1/download")) {
   $dir = "/tmp/usbmounts/sda1/download/";
   $dir_log = "/tmp/usbmounts/sda1/download/log/";
} elseif (file_exists("/tmp/usbmounts/sdb1/download")) {
   $dir = "/tmp/usbmounts/sdb1/download/";
   $dir_log = "/tmp/usbmounts/sdb1/download/log/";
} elseif (file_exists("/tmp/usbmounts/sdc1/download")) {
   $dir = "/tmp/usbmounts/sdc1/download/";
   $dir_log = "/tmp/usbmounts/sdc1/download/log/";
} elseif (file_exists("/tmp/usbmounts/sda2/download")) {
   $dir = "/tmp/usbmounts/sda2/download/";
   $dir_log = "/tmp/usbmounts/sda2/download/log/";
} elseif (file_exists("/tmp/usbmounts/sdb2/download")) {
   $dir = "/tmp/usbmounts/sdb2/download/";
   $dir_log = "/tmp/usbmounts/sdb2/download/log/";
} elseif (file_exists("/tmp/usbmounts/sdc2/download")) {
   $dir = "/tmp/usbmounts/sdc2/download/";
   $dir = "/tmp/usbmounts/sdc2/download/log/";
} elseif (file_exists("/tmp/hdd/volumes/HDD1/download")) {
   $dir = "/tmp/hdd/volumes/HDD1/download/";
   $dir_log = "/tmp/hdd/root/log/";
} else {
     $dir = "";
     $dir_log = "";
}
// end
?>
<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<onEnter>
    storagePath             = getStoragePath("tmp");
    storagePath_stream      = storagePath + "stream.dat";
    storagePath_playlist    = storagePath + "playlist.dat";
  setRefreshTime(1);
  first_time=1;
</onEnter>
 <onExit>
 setRefreshTime(-1);
 </onExit>
<onRefresh>
  if(first_time == 1)
  {
  setRefreshTime(-1);
  itemCount = getPageInfo("itemCount");
  first_time=0;
  }
  else if (do_down == 1)
  {
    topUrl = "http://127.0.0.1/cgi-bin/scripts/util/info_down.php?file=" + log_file + ",f";
    info_serial = getUrl(topUrl);
  }
</onRefresh>
<mediaDisplay name="threePartsView"
	itemBackgroundColor="0:0:0"
	backgroundColor="0:0:0"
	sideLeftWidthPC="0"
	sideRightWidthPC="0"
	sideColorRight="0:0:0"
	itemImageXPC="5"
	itemXPC="20"
	itemYPC="20"
	itemWidthPC="70"
	capWidthPC="70"
	unFocusFontColor="101:101:101"
	focusFontColor="255:255:255"
	showHeader="no"
	showDefaultInfo="yes"
	bottomYPC="90"
	infoYPC="100"
	infoXPC="0"
	popupXPC = "40"
  popupYPC = "55"
  popupWidthPC = "22.3"
  popupHeightPC = "5.5"
  popupFontSize = "13"
	popupBorderColor="28:35:51"
	popupForegroundColor="255:255:255"
 	popupBackgroundColor="28:35:51"
  idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10"
>
        <idleImage>image/POPUP_LOADING_01.png</idleImage>
        <idleImage>image/POPUP_LOADING_02.png</idleImage>
        <idleImage>image/POPUP_LOADING_03.png</idleImage>
        <idleImage>image/POPUP_LOADING_04.png</idleImage>
        <idleImage>image/POPUP_LOADING_05.png</idleImage>
        <idleImage>image/POPUP_LOADING_06.png</idleImage>
        <idleImage>image/POPUP_LOADING_07.png</idleImage>
        <idleImage>image/POPUP_LOADING_08.png</idleImage>
  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="18" fontSize="24" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>
  	<text align="left" offsetXPC="6" offsetYPC="15" widthPC="100" heightPC="4" fontSize="16" backgroundColor="10:105:150" foregroundColor="100:200:255">
    Apasati 1 pentru download manager, 2 pentru download, 3 pentru vizionare download, 4 verificare link
		</text>
  	<text  redraw="yes" align="center" offsetXPC="0" offsetYPC="90" widthPC="100" heightPC="8" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
    <script>print(info_serial); info_serial;</script>
		</text>
<onUserInput>
userInput = currentUserInput();
ret = "false";
if(userInput == "two" || userInput == "2")
{
tip=getItemInfo(getFocusItemIndex(),"tip");
showIdle();
if (tip == "1")
{
url =  getItemInfo(getFocusItemIndex(),"download");
movie=getUrl(url);
info_serial="link:" + movie;
topUrl = "http://127.0.0.1/cgi-bin/scripts/util/download.cgi?link=" + movie + ";name=" + getItemInfo(getFocusItemIndex(),"name");
}
else if (tip == "2")
{
topUrl = "http://127.0.0.1/cgi-bin/scripts/util/download.cgi?link=" + getItemInfo(getFocusItemIndex(),"download") + ";name=" + getItemInfo(getFocusItemIndex(),"name");
}
dummy = getUrl(topUrl);
cancelIdle();
do_down=1;
file_name= getItemInfo(getFocusItemIndex(),"title");
log_file="<?php echo $dir_log; ?>" + getItemInfo(getFocusItemIndex(),"name") + ".log";
setRefreshTime(10000);
ret="true";
}
else if (userInput == "three" || userInput == "3")
{
 url="<?php echo $dir; ?>" + getItemInfo(getFocusItemIndex(),"name");
 playItemurl(url,10);
 ret="true";
}
else if(userInput == "four" || userInput == "4")
{
showIdle();
url =  getItemInfo(getFocusItemIndex(),"download");
info_serial="link:" + url;
redrawdisplay();
tip=getItemInfo(getFocusItemIndex(),"tip");
if (tip == "1")
{
movie=getUrl(url);
info_serial="movie:" + movie;
}
cancelIdle();
redrawdisplay();
ret="true";
}
else if (userInput == "one" || userInput == "1")
{
jumpToLink("destination");
ret="true";
}
else
{
info_serial=" ";
setRefreshTime(-1);
do_down=0;
ret="false";
}
ret;
</onUserInput>
</mediaDisplay>
<destination>
	<link>http://127.0.0.1/cgi-bin/scripts/util/level.php
	</link>
</destination>
<channel>
<?php
echo "<title>".$pg_title."</title>"
;
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}

/**####################################**/
/** Here we start.......**/
$last_link = "";
if (strpos($filelink,"onlinemoca") === false) {
if (strpos($filelink,"filmeonlinesubtitrate.ro") !== false) {
  $post="pageviewnr=1";
  $ch = curl_init($filelink);
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  $html = curl_exec($ch);
  curl_close ($ch);
} else {
  $html = file_get_contents($filelink);
}
} else {
  $html="";
}
/**####################################onlinemoca###############**/
//Prea multe link-uri, trimit doar un link!
if (strpos($filelink, 'onlinemoca') !== false) {
   $filelink=$onlinemoca;
	if (strpos($filelink,"adf.ly") !==false) {
	   $h1=file_get_contents($filelink);
	   $filelink=str_between($h1,"var url = '","'");
    } else {
	  $t1=explode("link=",$filelink);
	  $filelink=$t1[1];
    }
	$server = str_between($filelink,"http://","/");
	$title = $server;
    $link="http://127.0.0.1/cgi-bin/scripts/filme/php/link.php?file=".urlencode($filelink);
        $server = str_between($filelink,"http://","/");
        $title=$server. " - With seek - SDK4";
	    echo'
	    <item>
	    <title>'.$title.'</title>
        <onClick>
        <script>
        showIdle();
        movie="'.$link.'";
        url=getUrl(movie);
        cancelIdle();
        streamArray = null;
        streamArray = pushBackStringArray(streamArray, "");
        streamArray = pushBackStringArray(streamArray, "");
        streamArray = pushBackStringArray(streamArray, url);
        streamArray = pushBackStringArray(streamArray, url);
        streamArray = pushBackStringArray(streamArray, video/x-flv);
        streamArray = pushBackStringArray(streamArray, "'.$pg_title.'");
        streamArray = pushBackStringArray(streamArray, "1");
        writeStringToFile(storagePath_stream, streamArray);
        doModalRss("rss_file:///usr/local/etc/www/cgi-bin/scripts/util/videoRenderer.rss");
        </script>
        </onClick>
        <download>'.$link.'</download>
        <tip>1</tip>
        <name>'.$titledownload.'.flv</name>
        </item>
        ';
}
/**################ All links ################**/
if(preg_match_all("/(http\b.*?)(\"|\')+/i",$html,$matches)) {
$links=$matches[1];
}
$s="/adf.ly|vidxden\.c|divxden\.c|vidbux\.c|movreel\.c|videoweed\.(c|e)|novamov\.(c|e)|vk\.com";
$s=$s."|movshare\.net|videobb\.c|youtube\.c|flvz\.com|rapidmov\.net|putlocker\.com|";
$s=$s."videozer\.com|peteava\.ro\/embed|peteava\.ro\/id|content\.peteava\.ro";
$s=$s."|vimeo\.com|googleplayer\.swf|filebox\.ro\/get_video|vkontakte\.ru|megavideo\.com";
$s=$s."/i";
for ($i=0;$i<count($links);$i++) {
  $cur_link=$links[$i];
  if (preg_match($s,$cur_link)) {
    if ($cur_link <> $last_link) {
      if (!preg_match("/facebook|twitter|img\.youtube/",$cur_link)) {
        $link="http://127.0.0.1/cgi-bin/scripts/filme/php/link.php?file=".urlencode($cur_link);
        $server = str_between($cur_link,"http://","/");
        $last_link=$cur_link;
        $title=$server. " - With seek - SDK4";
	    echo'
	    <item>
	    <title>'.$title.'</title>
        <onClick>
        <script>
        showIdle();
        movie="'.$link.'";
        url=getUrl(movie);
        cancelIdle();
        streamArray = null;
        streamArray = pushBackStringArray(streamArray, "");
        streamArray = pushBackStringArray(streamArray, "");
        streamArray = pushBackStringArray(streamArray, url);
        streamArray = pushBackStringArray(streamArray, url);
        streamArray = pushBackStringArray(streamArray, video/x-flv);
        streamArray = pushBackStringArray(streamArray, "'.$pg_title.'");
        streamArray = pushBackStringArray(streamArray, "1");
        writeStringToFile(storagePath_stream, streamArray);
        doModalRss("rss_file:///usr/local/etc/www/cgi-bin/scripts/util/videoRenderer.rss");
        </script>
        </onClick>
        <download>'.$link.'</download>
        <tip>1</tip>
        <name>'.$titledownload.'.flv</name>
        </item>
        ';
      }
    }
  }
}
/**################ special links ##############**/
if (preg_match_all('/<(iframe\b|object\b)[^>]+src\s?=\s?([\'|\"])(.*?)(\"|\')+/is', $html, $matches)) {
$links=$matches[3];
}
$link="";
$srt="";
for ($i=0;$i<count($links);$i++) {
  $cur_link=$links[$i];
    if (strpos($cur_link,"rofilm.info") !==false) {
     $baza = file_get_contents($cur_link);
     $t1=explode('value="file=',$baza);
     $t2=explode("&",$t1[1]);
     $link = $t2[0];
     if ($link=="") {
       $t1=explode("value='file=",$baza);
       $t2=explode("&",$t1[1]);
       $link=$t2[0];
     }
     $t1=explode('captions.file=',$baza);
     $t2=explode("&",$t1[1]);
     $srt=$t2[0];
     $srt = str_replace(" ","%20",$srt);
    } elseif (strpos($cur_link,"serialetvonline.info") !==false) {
      if (strpos($cur_link,"gettvguide2.php") === false) {
       $baza = file_get_contents($cur_link);
       $link = str_between($baza,'"flashvars" value="file=','&');
       $t1=explode('captions.file=',$baza);
       $t2=explode("&",$t1[1]);
       $srt=$t2[0];
       $srt = str_replace(" ","%20",$srt);
      }
     } elseif (strpos($cur_link,"rosharing.com") !==false) {
       $baza = file_get_contents($cur_link);
       $link = str_between($baza,'value="file=','&');
       $t1=explode('captions.file=',$baza);
       $t2=explode("&",$t1[1]);
       $srt=$t2[0];
       $srt = str_replace(" ","%20",$srt);
     } else {
       $link="";
       $srt="";
     }
  if ($link <> $last_link) {
  if ($link <> "") {
        $server = str_between($link,"http://","/");
        $title=$server. " - With seek - SDK4";
	    echo'
	    <item>
	    <title>'.$title.'</title>
        <onClick>
        <script>
        showIdle();
        url="'.$link.'";
        cancelIdle();
        streamArray = null;
        streamArray = pushBackStringArray(streamArray, "");
        streamArray = pushBackStringArray(streamArray, "");
        streamArray = pushBackStringArray(streamArray, url);
        streamArray = pushBackStringArray(streamArray, url);
        streamArray = pushBackStringArray(streamArray, video/x-flv);
        streamArray = pushBackStringArray(streamArray, "'.$pg_title.'");
        streamArray = pushBackStringArray(streamArray, "1");
        writeStringToFile(storagePath_stream, streamArray);
        doModalRss("rss_file:///usr/local/etc/www/cgi-bin/scripts/util/videoRenderer.rss");
        </script>
        </onClick>
        <download>'.$link.'</download>
        <tip>2</tip>
        <name>'.$titledownload.'.flv</name>
        </item>
        ';
  }
  if (($srt <> "") && (strpos($srt,".srt") !==false)) {
    	echo '
    	<item>
    	<title>Subtitrare</title>
    	<download>'.$srt.'</download>
    	<tip>2</tip>
        <name>'.$titledownload.'.srt</name>
    	</item>
    	';
  }
  $last_link = $link;
  }
}
/**################ flash... mediafile,file.....############**/
$videos = explode('flash', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1 = explode('ile=', $video);
  $t2 = explode('&', $t1[1]);
  $t3 = explode("'",$t2[0]);
  $link = urldecode($t3[0]);
  if (($link <> "") && strcmp($link,$lastlink)) {
     if (strpos($link, 'http://') !== false){
        $titledownload = $pg;
        $title=str_between($link,"http://","/");
        $ext=".flv";
    	$lastlink = $link;
		// for sdk4.... with seek
		$title=$title. " - With seek - SDK4";
	    echo'
	    <item>
	    <title>'.$title.'</title>
        <onClick>
        <script>
        showIdle();
        url="'.$link.'";
        cancelIdle();
        streamArray = null;
        streamArray = pushBackStringArray(streamArray, "");
        streamArray = pushBackStringArray(streamArray, "");
        streamArray = pushBackStringArray(streamArray, url);
        streamArray = pushBackStringArray(streamArray, url);
        streamArray = pushBackStringArray(streamArray, video/x-flv);
        streamArray = pushBackStringArray(streamArray, "'.$pg_title.'");
        streamArray = pushBackStringArray(streamArray, "1");
        writeStringToFile(storagePath_stream, streamArray);
        doModalRss("rss_file:///usr/local/etc/www/cgi-bin/scripts/util/videoRenderer.rss");
        </script>
        </onClick>
        <download>'.$link.'</download>
        <tip>2</tip>
        <name>'.$titledownload.'.'.$ext.'</name>
        </item>
        ';

    	$srt1 = str_between($video,'captions.file=','&');
    	$t1=explode('"',$srt1);
    	$srt = $t1[0];
    	if (strpos($srt,"http") === false) {
           ////www.veziserialeonline.info,www.seriale-filme.info
          $s1=explode("/",$filelink);
          $s=$s1[2];
          $srt="http://".$s.$srt;
        }
        $pct = substr($srt, -4, 1);
    	if (($srt <> "") && ($pct == ".") && (strpos($srt,".srt") !==false)) {
    	echo '
    	<item>
    	<title>Subtitrare</title>
    	<download>'.$srt.'</download>
    	<tip>2</tip>
        <name>'.$titledownload.'.srt</name>
    	</item>
    	';
    	}
    }
  }
} //foreach
?>
</channel>
</rss>
