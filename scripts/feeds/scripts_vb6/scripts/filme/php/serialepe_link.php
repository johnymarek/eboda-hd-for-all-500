#!/usr/local/bin/Resource/www/cgi-bin/php
<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
$host = "http://127.0.0.1/cgi-bin";
$query = $_GET["file"];
if($query) {
   $queryArr = explode(',', $query);
   $filelink = $queryArr[0];
   $pg_tit = urldecode($queryArr[1]);
   $pg = preg_replace('/[^A-Za-z0-9_]/','_',$pg_tit);
}
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
<rss version="2.0">
<onEnter>
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
if (file_name == "Subtitrare")
   {
    setRefreshTime(-1);
    topUrl = "http://127.0.0.1/cgi-bin/scripts/util/info_down.php?file=" + log_file + ",s";
    info_s = getUrl(topUrl);
    if (info_s == "Ready")
    {
    info_serial="Ready";
    }
    else
    {
     info_serial=info_s;
     setRefreshTime(2000);
    }
   }
   else
   {
    topUrl = "http://127.0.0.1/cgi-bin/scripts/util/info_down.php?file=" + log_file + ",f";
    info_serial = getUrl(topUrl);
   }
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
		<itemDisplay>
		<text align="left" lines="1" fontSize="16" foregroundColor="200:200:200" offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
				<script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
					if(focus==idx)
					{
					  info_serial = getItemInfo(idx, "info_serial");
					}
					getItemInfo(idx, "title");
				</script>
        </text>
		</itemDisplay>
  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="18" fontSize="24" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>
  	<text align="left" offsetXPC="6" offsetYPC="15" widthPC="100" heightPC="4" fontSize="16" backgroundColor="10:105:150" foregroundColor="100:200:255">
    Apasati 1 pentru download manager, 2 pentru download, 3 pentru vizionare download
		</text>
  	<text  redraw="yes" align="center" offsetXPC="0" offsetYPC="90" widthPC="100" heightPC="8" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
    <script>print(info_serial); info_serial;</script>
		</text>
<onUserInput>
userInput = currentUserInput();
ret = "false";
if( userInput == "one" || userInput == "1")
{
 jumpToLink("destination");
 ret="true";
}
else if(userInput == "two" || userInput == "2")
{
showIdle();
topUrl = "http://127.0.0.1/cgi-bin/scripts/util/download.cgi?link=" + getItemInfo(getFocusItemIndex(),"download") + ";name=" + getItemInfo(getFocusItemIndex(),"name");
dummy = getUrl(topUrl);
cancelIdle();
do_down=1;
file_name= getItemInfo(getFocusItemIndex(),"title");
log_file="<?php echo $dir_log; ?>" + getItemInfo(getFocusItemIndex(),"name") + ".log";
if (file_name == "Subtitrare")
{
url_xml="<?php echo $dir; ?>" + getItemInfo(getFocusItemIndex(),"name");
setRefreshTime(3000);
}
else
{
setRefreshTime(10000);
}
ret="true";
}
else if(userInput == "three" || userInput == "3")
{
url="<?php echo $dir; ?>" + getItemInfo(getFocusItemIndex(),"name");
playItemurl(url,10);
ret="true";
}
else
{
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
	<title><?echo $pg_tit; ?></title>
	<menu>main menu</menu>

<?php
$filename = "/tmp/serialepe.txt";
$handle = fopen($filename, "r");
$c = fread($handle, filesize($filename));
fclose($handle);
//wordpress_logged_in_0025812bd2bde5b9264279a4ae09be7b=vb6rocod%7C1310870465%7C859f920d152d2970290ec61b7a73614c; expires=Sun, 17-Jul-2011 02:41:05 GMT; path=/; httponly
$t=explode("wordpress_logged_in_",$c);
$t1=explode("\t",$t[1]);
$c = "wordpress_logged_in_".$t1[0]."=".trim($t1[1]).";";

$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: ro-ro,ro;q=0.8,en-us;q=0.6,en-gb;q=0.4,en;q=0.2\r\n" .
              "Cookie: ".$c."\r\n"
  )
);
$context = stream_context_create($opts);
$html = file_get_contents($filelink, false, $context);
$videos = explode('flash', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1 = explode('ile=', $video);
  $t2 = explode('&', $t1[1]);
  $t3 = explode("'",$t2[0]);
  $link = urldecode($t3[0]);
  if (strpos($link,"wp-content") !==false) {
    $t2=explode("&",$t1[2]);
    $t3=explode("'",$t2[0]);
    $link = urldecode($t3[0]);
  }

  $link = str_replace("s2.serialepe.net","s3.serialepe.net",$link);
  $srt1 = str_between($video,'captions.file=','&');
  $t1=explode('"',$srt1);
  $srt = $t1[0];
  $srt = str_replace("s2.serialepe.net","s3.serialepe.net",$srt);
  if ($link <> "") {
    $server = str_between($link,"http://","/");
    $title = $server." - ".substr(strrchr($link,"/"),1);
    $titledownload = $pg;
    $ext="flv";
    echo '
    <item>
   	<title>'.$title.'</title>
   	<link>'.$link.'</link>
   	<download>'.$link.'</download>
   	<name>'.$titledownload.'.'.$ext.'</name>
   	<info_serial>'.$info.'</info_serial>
   	<enclosure type="video/mp4" url="'.$link.'"/>
   	</item>
   	';
    // for sdk4.... with seek
    $title="Play with seek - SDK4";
	echo'
	<item>
	<title>'.$title.'</title>
    <onClick>
    <script>
    showIdle();
    url="'.$link.'";
    cancelIdle();
    storagePath = getStoragePath("tmp");
    storagePath_stream = storagePath + "stream.dat";
    streamArray = null;
    streamArray = pushBackStringArray(streamArray, "");
    streamArray = pushBackStringArray(streamArray, "");
    streamArray = pushBackStringArray(streamArray, url);
    streamArray = pushBackStringArray(streamArray, url);
    streamArray = pushBackStringArray(streamArray, video/mp4);
    streamArray = pushBackStringArray(streamArray, "'.$pg_tit.'");
    streamArray = pushBackStringArray(streamArray, "1");
    writeStringToFile(storagePath_stream, streamArray);
    doModalRss("rss_file:///usr/local/etc/www/cgi-bin/scripts/util/videoRenderer.rss");
    </script>
    </onClick>
    <download>'.$link.'</download>
    <name>'.$titledownload.'.'.$ext.'</name>
   	<info_serial>'.$info.'</info_serial>
  </item>
  ';

$pct = substr($srt, -4, 1);
if (($srt <> "") && ($pct == ".") && (strpos($srt,".srt") !==false)) {
   echo '
  	<item>
  	<title>Subtitrare</title>
  	<download>'.$srt.'</download>
     <name>'.$titledownload.'.srt</name>
  	 <info_serial>Descarca subtitrarea (cu tasta 2) si asteapta pana apare "Ready"</info_serial>
  	 </item>
   	';
}
}
}
// utils
    $link = "http://127.0.0.1/cgi-bin/scripts/util/util1.cgi";
  	echo '
    <item>
  	<title>Stop download (numai pentru metoda sageata dreapta-download)</title>
  	<link>'.$link.'</link>
  	<enclosure type="text/txt" url="'.$link.'"/>
  	<info_serial>Stop download (numai pentru metoda sageata dreapta-download)</info_serial>
  	</item>
      ';
?>
</channel>
</rss>
