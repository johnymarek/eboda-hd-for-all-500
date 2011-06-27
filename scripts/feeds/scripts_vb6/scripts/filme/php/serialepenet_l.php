<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
$host = "http://127.0.0.1:82";
$query = $_GET["file"];
if($query) {
   $queryArr = explode(',', $query);
   $link = $queryArr[0];
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
    topUrl = "http://127.0.0.1:82/scripts/util/info_down.php?file=" + log_file + ",s";
    info_s = getUrl(topUrl);
    if (info_s == "Ready")
    {
    showIdle();
    topUrl = "http://127.0.0.1:82/scripts/util/xml_srt1.php?file=" + url_xml;
    dummy = getUrl(topUrl);
    cancelIdle();
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
    topUrl = "http://127.0.0.1:82/scripts/util/info_down.php?file=" + log_file + ",f";
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
topUrl = "http://127.0.0.1:82/scripts/util/download.cgi?link=" + getItemInfo(getFocusItemIndex(),"download") + ";name=" + getItemInfo(getFocusItemIndex(),"name");
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
	<link>http://127.0.0.1:82/scripts/util/level.php
	</link>
</destination>

<channel>
	<title><?echo $pg_tit; ?></title>
	<menu>main menu</menu>

<?php
$pass = trim(file_get_contents("/usr/local/etc/dvdplayer/serialepe.txt"));
//cod=asbghtyi&activare=Activeaza
$post = "cod=".$pass."&activare=Activeaza";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
curl_setopt($ch, CURLOPT_REFERER, $link);
curl_setopt ($ch, CURLOPT_POST, 1);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
$html = curl_exec($ch);
curl_close($ch);
$t1=explode("Urmareste online serialul",$html);
$t2=explode("<",$t1[1]);
$info=trim($t2[0]);
$html=urldecode(str_between($html,"document.write(unescape('","+unescape"));
$t1=explode('src="',$html);
$t2=explode("'",$t1[1]);
$part1=$t2[0];
$part2=$t2[2];
$l=$part1.$part2;
if ($l <> "") {
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $l);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
$html = curl_exec($ch);
curl_close($ch);

$t1=explode("file=",$html);
$t2=explode("&",$t1[1]);
$link=$t2[0];
$t1=explode("file=",$html);
$t2=explode("&",$t1[2]);
$srt=$t2[0];
} else {
$link="";
}
if ($link <> "") {
$server = str_between($link,"http://","/");
$title = $server." - ".substr(strrchr($link,"/"),1);
$titledownload = $pg;
$ext="mp4";
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
    doModalRss("rss_file:///scripts/util/videoRenderer.rss");
    </script>
    </onClick>
    <download>'.$link.'</download>
    <name>'.$titledownload.'.'.$ext.'</name>
   	<info_serial>'.$info.'</info_serial>
  </item>
  ';

$pct = substr($srt, -4, 1);
if (($srt <> "") && ($pct == ".") && (strpos($srt,".xml") !==false)) {
   echo '
  	<item>
  	<title>Subtitrare</title>
  	<download>'.$srt.'</download>
     <name>'.$titledownload.'.xml</name>
  	 <info_serial>Descarca subtitrarea (cu tasta 2) si asteapta pana apare "Ready"</info_serial>
  	 </item>
   	';
}
}
// utils
   echo '
   <item>
   <title>Setare parola - abonament</title>
   <onClick>
   <script>
	 keyword = getInput();
	 if (keyword != null)
	 {
        storagePath = "/usr/local/etc/dvdplayer/serialepe.txt";
        arr = null;
        arr = pushBackStringArray(arr, keyword);
        writeStringToFile(storagePath, arr);
	 }
   </script>
   </onClick>
   <info_serial>Necesita abonament pe serialepenet.ro!</info_serial>
   </item>
   ';
   echo '
   <item>
   <title>Conversie subtitrare (xml-srt) - dupa download subtitrare</title>
   <onClick>
   <script>
        showIdle();
		topUrl = "http://127.0.0.1:82/scripts/util/xml_srt.php";
		dummy = getUrl(topUrl);
		cancelIdle();
   </script>
   </onClick>
   <info_serial>Conversie la toate subtitrarile din format xml in format srt</info_serial>
   </item>
   ';
    $link = "http://127.0.0.1:82/scripts/util/util1.cgi";
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
