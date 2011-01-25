#!/usr/local/bin/Resource/www/cgi-bin/php
<?php echo "<?xml version='1.0' encoding='UTF8' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<onEnter>
  setRefreshTime(3000);
</onEnter>
<onExit>
  setRefreshTime(-1);
</onExit>
<onRefresh>
  logfile = getItemInfo(getFocusItemIndex(),"logfile");
  print("**** logfile=",logfile);
  if (logfile == 1)
  {
    info = "Apasti 1 sau 2 pentru a opri toate descarcarile";
  }
  else
  {
    url="http://127.0.0.1/cgi-bin/scripts/util/download.php?file=" + logfile;
    info=getURL(url);
  }
</onRefresh>
<mediaDisplay name="onePartsView" 
	itemBackgroundColor="0:0:0" 
	backgroundColor="0:0:0" 
	sideLeftWidthPC="0" 
	itemImageXPC="5" 
	itemImageYPC="24"
	itemImageWidthPC="5"
	itemImageHeightPC="5"
	itemXPC="10" 
	itemYPC="20" 
	itemWidthPC="75" 
	capWidthPC="80" 
	unFocusFontColor="101:101:101" 
	focusFontColor="255:255:255" 
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
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=18 offsetYPC=8 widthPC=82 heightPC=10 fontSize=18 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
  Folositi tastele: 1=Sterge din lista 2=start/stop 3=Home (return)
		</text>	
<text align="center" redraw="yes" lines="4" offsetXPC=10 offsetYPC=90 widthPC=80 heightPC=10 fontSize=15 backgroundColor=0:0:0 foregroundColor=120:120:120>
<script>info;</script>
</text>
</mediaDisplay>
<destination>
	<link>http://127.0.0.1/cgi-bin/scripts/util/level.php</link>
</destination>
<destination1>
	<link>http://127.0.0.1/cgi-bin/scripts/mini1.php</link>
</destination1>
<channel>
	<title>Download</title>
	<menu>main menu</menu>
    <item>
    <title>Stop toate - curata lista</title>
	<download>http://127.0.0.1/cgi-bin/scripts/util/stop_exua.cgi</download>
	<download1>http://127.0.0.1/cgi-bin/scripts/util/stop_exua.cgi</download1>
	<logfile>1</logfile>
	<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/util/image/fon.jpg" />
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
	<download>http://127.0.0.1/cgi-bin/scripts/util/manag.cgi?link='.$link.';name='.$t1[0].';go=start</download>
	<download1>http://127.0.0.1/cgi-bin/scripts/util/manag.cgi?name='.$t1[0].';go=delete</download1>
	<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/util/image/off.jpg" />';
	else
	echo '
		<download>http://127.0.0.1/cgi-bin/scripts/util/manag.cgi?pid='.$pid[0].';name='.$t1[0].';go=stop</download>
		<download1>http://127.0.0.1/cgi-bin/scripts/util/manag.cgi?name='.$t1[0].';go=delete</download1>
	<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/util/image/on.jpg" />';
	} else
	 echo '
	<download>http://127.0.0.1/cgi-bin/scripts/util/manag.cgi?name='.$t1[0].';go=delete</download>
	<download1>http://127.0.0.1/cgi-bin/scripts/util/manag.cgi?name='.$t1[0].';go=delete</download1>
	<media:thumbnail url="/usr/local/etc/www/cgi-bin/scripts/util/image/end.jpg" />';
	echo '
    </item>
    ';
}
}
?>

</channel>
</rss>
