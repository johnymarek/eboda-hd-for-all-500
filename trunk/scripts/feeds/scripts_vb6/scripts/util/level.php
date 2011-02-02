<?php echo "<?xml version='1.0' encoding='UTF8' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<onEnter>
  setRefreshTime(100);
  status=0;
</onEnter>
<onExit>
  setRefreshTime(-1);
</onExit>
<onRefresh>
  if (status == 0)
    {
     itemCount = getPageInfo("itemCount");
     status=1;
     setRefreshTime(3000);
    }
  logfile = getItemInfo(getFocusItemIndex(),"logfile");
  print("**** logfile=",logfile);
  if (logfile == 1)
  {
    info = "Apasti 1 sau 2 pentru a opri toate descarcarile";
  }
  else
  {
    url="http://127.0.0.1:82/scripts/util/download.php?file=" + logfile;
    info=getURL(url);
  }
</onRefresh>
<mediaDisplay name="threePartsView"
	sideLeftWidthPC="0"
	sideRightWidthPC="0"
	headerImageWidthPC="0"
	selectMenuOnRight="no"
	autoSelectMenu="no"
	autoSelectItem="no"
	itemImageXPC="5"
	itemImageHeightPC="5"
	itemImageWidthPC="5"
	itemXPC="12"
	itemYPC="25"
	itemWidthPC="80"
	itemHeightPC="8"
	capWidthPC="70"
	capHeightPC="64"
	itemBackgroundColor="0:0:0"
	itemPerPage="8"
    itemGap="0"
	bottomYPC="90"
	backgroundColor="0:0:0"
	showHeader="no"
	showDefaultInfo="no"
	imageFocus=""
	sliding="no"
	idleImageWidthPC="10"
	idleImageHeightPC="10">
  	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="20" fontSize="24" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>

  	<text redraw="yes" offsetXPC="85" offsetYPC="12" widthPC="10" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>
  	<text  redraw="yes" align="center" offsetXPC="0" offsetYPC="90" widthPC="100" heightPC="8" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(info); info;</script>
		</text>
        <idleImage>image/POPUP_LOADING_01.png</idleImage>
        <idleImage>image/POPUP_LOADING_02.png</idleImage>
        <idleImage>image/POPUP_LOADING_03.png</idleImage>
        <idleImage>image/POPUP_LOADING_04.png</idleImage>
        <idleImage>image/POPUP_LOADING_05.png</idleImage>
        <idleImage>image/POPUP_LOADING_06.png</idleImage>
        <idleImage>image/POPUP_LOADING_07.png</idleImage>
        <idleImage>image/POPUP_LOADING_08.png</idleImage>
		<itemDisplay>
			<text align="left" lines="1" offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
				<script>
					idx = getQueryItemIndex();
					getItemInfo(idx, "title");
				</script>
				<fontSize>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "14"; else "14";
  				</script>
				</fontSize>
			  <backgroundColor>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "10:80:120"; else "-1:-1:-1";
  				</script>
			  </backgroundColor>
			  <foregroundColor>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "255:255:255"; else "140:140:140";
  				</script>
			  </foregroundColor>
			</text>
		</itemDisplay>
<onUserInput>
	userInput = currentUserInput();

	if( userInput == "two")
	{
		url=getItemInfo(getFocusItemIndex(),"download");
		dlok = loadXMLFile(url);
		jumpToLink("destination");
	}
		else
    if (userInput == "one")
		{
		url=getItemInfo(getFocusItemIndex(),"download1");
		dlok = loadXMLFile(url);
		jumpToLink("destination");
		}
		else
    if (userInput == "three")
		{
		jumpToLink("destination1");
		}
</onUserInput>
</mediaDisplay>
<destination>
	<link>http://127.0.0.1:82/scripts/util/level.php</link>
</destination>
<destination1>
	<link>http://127.0.0.1:82/scripts/mini1.php</link>
</destination1>
<channel>
	<title>Folositi tastele: 1=Sterge din lista 2=start/stop 3=Home (return)</title>
	<menu>main menu</menu>
    <item>
    <title>Stop toate - curata lista</title>
	<download>http://127.0.0.1:82/scripts/util/stop_exua.cgi</download>
	<download1>http://127.0.0.1:82/scripts/util/stop_exua.cgi</download1>
	<logfile>1</logfile>
	<media:thumbnail url="/scripts/util/image/fon.jpg" />
    </item>
<?php
clearstatcache();
if (file_exists("/tmp/usbmounts/sda1/download")) {
   $dir = "/tmp/usbmounts/sda1/download/log/*log";
} elseif (file_exists("/tmp/usbmounts/sdb1/download")) {
   $dir = "/tmp/usbmounts/sdb1/download/log/*log";
} elseif (file_exists("/tmp/usbmounts/sdc1/download")) {
   $dir = "/tmp/usbmounts/sdc1/download/log/*log";
} elseif (file_exists("/tmp/usbmounts/sda2/download")) {
   $dir = "/tmp/usbmounts/sda2/download/log/*log";
} elseif (file_exists("/tmp/usbmounts/sdb2/download")) {
   $dir = "/tmp/usbmounts/sdb2/download/log/*log";
} elseif (file_exists("/tmp/usbmounts/sdc2/download")) {
   $dir = "/tmp/usbmounts/sdc1/download/log/*log";
} elseif (file_exists("/tmp/hdd/volumes/HDD1/download")) {
   $dir = "/tmp/hdd/root/log/*log";
} else {
     $dir = "";
}
if ($dir <> "") {
$file_list = glob($dir);
for ($i=0; $i< count($file_list); $i++) {
$log_file = file($file_list[$i]);
$t1 = explode('/log/', $file_list[$i]);
$t1 = explode('.log', $t1[1]);
$log = $log_file[count($log_file) -4];
$t3 = explode("K", $log);
$t4 = substr($log, -25);
$t5 = explode("%", $log);
$end = substr($t5[0], -3);
$t0 = $i+1;
//pid
$pd = "/tmp/".$t1[0].".pid";
$pid_file = file($pd);
$pid = explode('pid ', $pid_file[0]);
$pid = explode('.', $pid[1]);
//url
$log_url =  $log_file[0];
$url = explode('http://', $log_url);
$link = str_replace("\r","",$url[1]);	
$link = str_replace("\n","",$link);
$link = 'http://'.$link;
//title
$title = $t0.'. '. $t1[0].' -  '.$t3[0].'KB'.$t4;
   echo '
    <item>
    <title>'.$title.'</title>';
	echo '<name>'.$t1[0].'</name>';
	echo '<logfile>'.$file_list[$i].'</logfile>';
	if ($end != "100") {
	if (!$pid_file)  echo '
	<download>http://127.0.0.1:82/scripts/util/manag.cgi?link='.$link.';name='.$t1[0].';go=start</download>
	<download1>http://127.0.0.1:82/scripts/util/manag.cgi?name='.$t1[0].';go=delete</download1>
	<media:thumbnail url="/scripts/util/image/off.jpg" />';
	else
	echo '
		<download>http://127.0.0.1:82/scripts/util/manag.cgi?pid='.$pid[0].';name='.$t1[0].';go=stop</download>
		<download1>http://127.0.0.1:82/scripts/util/manag.cgi?name='.$t1[0].';go=delete</download1>
	<media:thumbnail url="/scripts/util/image/on.jpg" />';
	} else
	 echo '
	<download>http://127.0.0.1:82/scripts/util/manag.cgi?name='.$t1[0].';go=delete</download>
	<download1>http://127.0.0.1:82/scripts/util/manag.cgi?name='.$t1[0].';go=delete</download1>
	<media:thumbnail url="/scripts/util/image/end.jpg" />';
	echo '
    </item>
    ';
}
}
?>

</channel>
</rss>
