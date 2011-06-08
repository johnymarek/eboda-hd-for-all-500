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
echo "<video>";
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
	<image>/scripts/util/image/off.jpg</image>';
	else
	echo '
		<download>http://127.0.0.1:82/scripts/util/manag.cgi?pid='.$pid[0].';name='.$t1[0].';go=stop</download>
		<download1>http://127.0.0.1:82/scripts/util/manag.cgi?name='.$t1[0].';go=delete</download1>
	<image>/scripts/util/image/on.jpg</image>';
	} else
	 echo '
	<download>http://127.0.0.1:82/scripts/util/manag.cgi?name='.$t1[0].';go=delete</download>
	<download1>http://127.0.0.1:82/scripts/util/manag.cgi?name='.$t1[0].';go=delete</download1>
	<image>/scripts/util/image/end.jpg</image>';
	echo '
    </item>
    ';
}
}
echo "</video>";
?>
