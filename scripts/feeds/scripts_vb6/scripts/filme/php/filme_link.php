<?php
error_reporting(0);
$filelink=$_ENV["QUERY_STRING"];
$t1=explode(",",$filelink);
$filelink = $t1[0];
$filelink = str_replace("*",",",$filelink);
$filelink = str_replace("@","&",$filelink); //seriale.subtitrate.info
$pg = urldecode($t1[1]);
if ($pg == "") {
   $pg_title = "Link";
} else {
  $pg_title = $pg;
  $pg = preg_replace('/[^A-Za-z0-9_]/','_',$pg);
}
$onlinemoca=$t1[2];
//play movie
if (file_exists("/tmp/usbmounts/sda1/download")) {
   $dir = "/tmp/usbmounts/sda1/download/";
} elseif (file_exists("/tmp/usbmounts/sdb1/download")) {
   $dir = "/tmp/usbmounts/sdb1/download/";
} elseif (file_exists("/tmp/usbmounts/sdc1/download")) {
   $dir = "/tmp/usbmounts/sdc1/download/";
} elseif (file_exists("/tmp/usbmounts/sda2/download")) {
   $dir = "/tmp/usbmounts/sda2/download/";
} elseif (file_exists("/tmp/usbmounts/sdb2/download")) {
   $dir = "/tmp/usbmounts/sdb2/download/";
} elseif (file_exists("/tmp/usbmounts/sdc2/download")) {
   $dir = "/tmp/usbmounts/sdc2/download/";
} elseif (file_exists("/tmp/hdd/volumes/HDD1/download")) {
   $dir = "/tmp/hdd/volumes/HDD1/download/";
} else {
     $dir = "";
}
// end
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
    Apasati 2 pentru download, 3 pentru vizionare download
		</text>
<onUserInput>
	userInput = currentUserInput();

	if( userInput == "two")
	{
		topUrl = "http://127.0.0.1:82/scripts/util/download.cgi?link=" + getItemInfo(getFocusItemIndex(),"download") + ";name=" + getItemInfo(getFocusItemIndex(),"name");
		dlok = loadXMLFile(topUrl);
	}
	else
    if (userInput == "three")
		{
         url="<?php echo $dir; ?>" + getItemInfo(getFocusItemIndex(),"name");
         playItemurl(url,10);
		}

</onUserInput>
</mediaDisplay>
<destination>
	<link>http://127.0.0.1:82/scripts/util/level.php
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
function str_prep($string){
  $string = str_replace(' ','%20',$string);
  $string = str_replace('[','%5B',$string);
  $string = str_replace(']','%5D',$string);
  $string = str_replace('%3A',':',$string);
  $string = str_replace('%2F','/',$string);
  $string = str_replace('#038;','',$string);
  $string = str_replace('&amp;','&',$string);
  return $string;
}
/** divxden.com,vidxden.com,vidbux.com**/
function vix($string) {
$server = str_between($string,"http://","/");
if (strpos($string,"wootly") === false) {
  if (strpos($string,"embed") === false) {
    $l1 = str_between($string,'.com/','/');
    $link = "http://".$server."/embed-".$l1."-width-653-height-362.html";
  } else {
    $link = $string;
  }
  $h = file_get_contents($link);
} else {
  $id= substr(strrchr($string,"/"),1);
  $post="op=download1&usr_login=&id=".$id."&fname=&referer=&method_free=Continue+To+Video";
  if (function_exists('curl_init')) {
  $ch = curl_init($string);
  curl_setopt ($ch, CURLOPT_POST, 1);
  curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
  $h = curl_exec($ch);
  curl_close ($ch);
  } else {
  //wget solution
  exec("rm -f /tmp/vix");
  $c="/sbin/wget -q --post-data '".$post."' ".$string." -O /tmp/vix";
  exec($c);
  $h=file_get_contents("/tmp/vix");
  }
}

$g=ord("g");
$f=explode("return p}",$h);
$e=explode("'.split",$f[1]);
$t=$e[0];
$a=explode(";",$t);
if (strpos($string,"vidbux") !== false) {
   $t1=explode("'",$a[4]);
} else {
  $t1=explode("'",$a[5]);
}
//3=4://0.3.2:o/d/n/8.m
$link= $t1[3];
$s1=explode("/",$link);

$s2=explode(".",$s1[2]);
$server1=ord($s2[0]);
if ($server1 < 58) {
  $server1=$s2[0];
} else {
  $server1=$server1-$g + 16;
}
$host=ord($s2[1]);
if ($host < 58) {
  $host=$s2[1];
} else {
  $host=$host-$g + 16;
}
$s3=explode(":",$s2[2]);
$com=ord($s3[0]);
if ($com < 58) {
  $com=$s3[0];
} else {
  $com=$com-$g + 16;
}
$port=ord($s3[1]);
if ($port < 58) {
  $port=$s3[1];
} else {
  $port=$port-$g + 16;
}
$key= ord($s1[4]);
if ($key < 58) {
  $key=$s1[4];
} else {
  $key=$key-$g + 16;
}
if ($key=="") return "";
if (strpos($string,"vidbux") !== false) {
   $a1=explode("'",$a[8]);
} else {
  $a1=explode("'",$a[11]);
}
$t1=explode("|",$a1[2]);
$videos=explode(".",$s1[5]);
foreach($videos as $video) {
  $ns=explode("-",$video);
  $mys="";
  foreach ($ns as $n) {
    $n1=ord($n);
    if ($n1 < 58) {
      $n1=$n;
    } else {
      $n1=$n1-$g+16;
    }
    $mys=$mys.$t1[$n1]."-";
  }
  $mys=rtrim($mys,"-");
  $myss=$myss.".".$mys;
}
$myss=rtrim($myss,".");
$myss=ltrim($myss,".");
$l = "http://".$t1[$server1].".".$t1[$host].".".$t1[$com].":".$t1[$port]."/d/".$t1[$key]."/".$myss;
return $l;
}
function nukeshare($string) {
  //http://www.nukeshare.com:182/d/nj27226jmwazz6v7wqdn2huhhxat7dxdqwwnkdokhrvvlkemhmkryx5f/video.flv
  $h = file_get_contents($string);
  $h = str_between($h,"s1|addVariable|","split");
  $a = explode("|",$h);
  for ($i=0;$i<30;$i++) {
      if ((strlen($a[$i]) >= 39) && (strpos($a[$i],"_") === false)) {
           $hash = $a[$i];
           break;
      }
  }
  if ($hash <> "") {
    $link="http://www.nukeshare.com:182/d/".$hash."/video.flv";
  } else {
    $link="";
  }
  return $link;
}
function divxden($string) {
  $server = str_between($string,"http://","/");
  if (strpos($string,"embed") === false) {
    $l1 = str_between($string,'.com/','/');
    $link = "http://".$server."/embed-".$l1."-width-653-height-362.html";
  } else {
    $link = $string;
  }
  $h = file_get_contents($link);
  $x = str_between($h,"top.location.href='","'");
  $y = substr(strrchr($x,"/"),1);
  $z = substr($y, 0, -5);
  $h = str_between($h,"s1|addVariable|","split");
  $a = explode("|",$h);
  for ($i=0;$i<30;$i++) {
      if ((strlen($a[$i]) >= 39) && (strpos($a[$i],"_") === false)) {
           $hash = $a[$i];
           break;
      }
  }
  for ($i=0;$i<30;$i++) {
      if ((strlen($a[$i]) == 3) && (strpos($a[$i],"_") === false) && (($a[$i][0] == "s") || ($a[$i][0] == "w")) && ($a[$i] <> "swf")) {
		$s = $a[$i];
		break;
      }
  }
  if ($s == "") {
     for ($i=0;$i<30;$i++) {
         if ((strlen($a[$i]) == 2) && (strpos($a[$i],"_") === false)) {
            $s = $a[$i];
            break;
         }
     }
  }
  if ($s == "") {
     $s = $a[20];
  }
  if ($hash <> "") {
    $link = "http://".$s.".divxden.com:182"."/d/".$hash."/".$z;
    $AgetHeaders = @get_headers($link);
    if (preg_match("|text/html|", $AgetHeaders[3])) {
    $link = "http://".$s.".vidxden.com:182"."/d/".$hash."/".$z;
	   $AgetHeaders = @get_headers($link);
        if (!preg_match("|200|", $AgetHeaders[0])) {
           $link = "http://".$s.".vidbux.com:182"."/d/".$hash."/".$z;
		   $AgetHeaders = @get_headers($link);
		   if (!preg_match("|200|", $AgetHeaders[0])) {
		      $link = "";
            }
		}
	}
  } else {
      $link="";
  }
  return $link;
}
function zeroFill($a,$b) {
    if ($a >= 0) {
        return bindec(decbin($a>>$b)); //simply right shift for positive number
    }
    $bin = decbin($a>>$b);
    $bin = substr($bin, $b); // zero fill on the left side
    $o = bindec($bin);
    return $o;
}
function crunch($arg1,$arg2) {
  $local4 = strlen($arg2);
  while ($local5 < $local4) {
   $local3 = ord(substr($arg2,$local5));
   $arg1=$arg1^$local3;
   $local3=$local3%32;
   $arg1 = ((($arg1 << $local3) & 0xFFFFFFFF) | zeroFill($arg1,(32 - $local3)));
   $local5++;
  }
  return $arg1;
}
function peteava($movie) {
  $seedfile=file_get_contents("http://content.peteava.ro/seed/seed.txt");
  $t1=explode("=",$seedfile);
  $seed=$t1[1];
  if ($seed == "") {
     return "";
  }
  $s = hexdec($seed);
  $local3 = crunch($s,$movie);
  $local3 = crunch($local3,"0");
  $local3 = crunch($local3,"1fe71d22");
  return strtolower(dechex($local3));
}
/** end divxden function **/
/**####################################**/
/** Here we start.......**/
$lastlink = "abc";
$baseurl = "http://127.0.0.1:83/cgi-bin/translate?stream,Content-type:video/x-flv,";
$filelink = str_prep($filelink);
if (strpos($filelink,"onlinemoca") === false) {
if (strpos($filelink,"serialepe") !==false) {
$filename = "/tmp/serialepe.txt";
$handle = fopen($filename, "r");
$c = fread($handle, filesize($filename));
fclose($handle);
if (!function_exists('curl_init')) {
   $t=explode("wordpress_logged_in_",$c);
   $t1=explode("\t",$t[1]);
   $c = "wordpress_logged_in_".$t1[0]."=".trim($t1[1]).";";
}

$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: ro-ro,ro;q=0.8,en-us;q=0.6,en-gb;q=0.4,en;q=0.2\r\n" .
              "Cookie: ".$c."\r\n"
  )
);
  $context = stream_context_create($opts);
  $html = file_get_contents($filelink, false, $context);
} else {
  $html = file_get_contents($filelink);
}
} else {
  $html="";
}
/**################################filmeonlinesubtitrate.ro###############**/
if (strpos($filelink, 'filmeonlinesubtitrate.ro') !== false) {
$videos = explode('file:',$html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1 = explode("'",$video);
  $t2 = explode("'",$t1[1]);
  $l = trim($t2[0]);
  $h = file_get_contents($l);
  $link = str_between($h,"<location>","</location>");
  $server = str_between($link,"http://","/");
  $title = $server." - ".substr(strrchr($link,"/"),1);
  if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
     $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
     echo '
     <item>
     <title>'.$title.'</title>
     <name>'.$titledownload.'.'.$ext.'</name>
     <download>'.$link.'</download>
	 <link>'.$link1.'</link>
     <enclosure type="video/flv" url="'.$link1.'"/>
     </item>
     ';
 	$lastlink = $link;
  }
}
}
/**#######################onlythefilm##############################**/
//http://www.onlythefilm.com/filmeonline.png
if (strpos($filelink, 'onlythefilm') !== false) {
$videos = explode("file: '",$html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1 = explode("'",$video);
  $link = $t1[0];
  $link = str_prep($link);
  $h1=  file_get_contents($link);
  $link1 = trim(str_between($h1,"<location>","</location>"));
  $server = str_between($link1,"http://","/");
  $title = $server." - ".substr(strrchr($link1,"/"),1);
	if (($link1 <> "") && strcmp($link1,$lastlink) && (strpos($link1,"http") !== false) && (!preg_match("/<|>/",$title))) {
		$link2 = $baseurl.$link1;
 		$titledownload = substr(strrchr($link1,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link1.'</download>
    	<link>'.$link2.'</link>
    	<enclosure type="video/flv" url="'.$link2.'"/>
    	</item>
        ';
		$lastlink = $link1;
    }   //lastlink
}
$videos = explode('a href="',$html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  if (strpos($video,'http://www.onlythefilm.com/filmeonline.png') !== false) {
    $t1 = explode("?",$video);
    $t2 = explode('"',$t1[1]);
    $link = trim($t2[0]);
	$server = str_between($link,"http://","/");
	$title = $server;
	$link = str_prep($link);
	if (strpos($link, 'videoweed') !== false) {
		$h1 = file_get_contents($link);
		$link1 = str_between($h1,'file="','"');
		$title = $server." - ".substr(strrchr($link1,"/"),1);
	} elseif (strpos($link, 'novamov') !== false) {
		$h1 = file_get_contents($link);
		$link1 = str_between($h1,'file="','"');
		$title = $server." - ".substr(strrchr($link1,"/"),1);
	} elseif (strpos($link, 'flvz') !== false) {
		$h1 = file_get_contents($link);
		$t1 = explode('<iframe',$h1);
		$t2 = explode('src="',$t1[1]);
		$t3 = explode('"',$t2[1]);
		$h1 = file_get_contents($t3[0]);
		$link1 = str_between($h1,'"url": "','"');
		$title = $server." - ".substr(strrchr($link1,"/"),1);
	} elseif (strpos($link, 'movshare') !== false){
      $link = "http://www.movshare.net/embed/".substr(strrchr($link,"/"),1);
	  $baza = file_get_contents($link);
	  $link1 = str_between($baza,'addVariable("file","','"');
	  if ($link1 == "") {
	     $link1 = str_between($baza,'param name="src" value="','"');
      }
      if ($link1 == "") {
         $link1=str_between($baza,'flashvars.file="','"');
      }
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif (strpos($link,'stickonline') !== false) {
      $baza = file_get_contents($link);
      $link1 = str_between($baza,"file=","&");
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif ((strpos($link, 'divxden.com') !== false) ||(strpos($link, 'vidxden.com') !== false) ||(strpos($link, 'vidbux.com') !== false) ||(strpos($link, 'wootly.com') !== false)) {
      $link1 = vix($link);
      $server = str_between($link1,"http://","/");
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif (strpos($link,'movreel') !==false) {
      $link = "http://movreel.com/embed/".substr(strrchr($link,"/"),1);
      $baza = file_get_contents($link);
      $link1=str_between($baza,'<param name="src" value="','"');
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif (strpos($link, 'loombo.com') !== false) {
      $l1=substr(strrchr($link,"/"),1);
      //http://loombo.com/embed-nztor3f4stri-640x318.html
      $link = "http://loombo.com/embed-".$l1."-640x318.html";
      $baza = file_get_contents($link);
      $link1 = str_between($baza,"addParam('flashvars','file=","'");
      $server = str_between($link,"http://","/");
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } else {
      $link1 = "";
    }
	if (($link1 <> "") && strcmp($link1,$lastlink) && (strpos($link1,"http") !== false) && (!preg_match("/<|>/",$title))) {
		$link2 = $baseurl.$link1;
 		$titledownload = substr(strrchr($link1,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link1.'</download>
    	<link>'.$link2.'</link>
    	<enclosure type="video/flv" url="'.$link2.'"/>
    	</item>
        ';
		$lastlink = $link1;
    }   //lastlink
}  //foreach
}
}
/** END onlythefilm **/
/**####################################onlinemoca###############**/
//Prea multe link-uri, trimit doar un link!
if (strpos($filelink, 'onlinemoca') !== false) {
	$link = $onlinemoca;
	$server = str_between($link,"http://","/");
	$title = $server;
	$link = str_prep($link);
	if (strpos($link, 'videoweed') !== false) {
		$h1 = file_get_contents($link);
		$link1 = str_between($h1,'file="','"');
		$title = $server." - ".substr(strrchr($link1,"/"),1);
	} elseif (strpos($link, 'novamov') !== false) {
		$h1 = file_get_contents($link);
		$link1 = str_between($h1,'file="','"');
		$title = $server." - ".substr(strrchr($link1,"/"),1);
	} elseif (strpos($link, 'flvz') !== false) {
		$h1 = file_get_contents($link);
		$t1 = explode('<iframe',$h1);
		$t2 = explode('src="',$t1[1]);
		$t3 = explode('"',$t2[1]);
		$h1 = file_get_contents($t3[0]);
		$link1 = str_between($h1,'"url": "','"');
		$title = $server." - ".substr(strrchr($link1,"/"),1);
	} elseif (strpos($link, 'movshare') !== false){
      $link = "http://www.movshare.net/embed/".substr(strrchr($link,"/"),1);
	  $baza = file_get_contents($link);
	  $link1 = str_between($baza,'addVariable("file","','"');
	  if ($link1 == "") {
	     $link1 = str_between($baza,'param name="src" value="','"');
      }
      if ($link1 == "") {
         $link1=str_between($baza,'flashvars.file="','"');
      }
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif (strpos($link,'stickonline') !== false) {
      $baza = file_get_contents($link);
      $link1 = str_between($baza,"file=","&");
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif (strpos($link,'movreel') !==false) {
      $link = "http://movreel.com/embed/".substr(strrchr($link,"/"),1);
      $baza = file_get_contents($link);
      $link1=str_between($baza,'<param name="src" value="','"');
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif ((strpos($link, 'divxden.com') !== false) ||(strpos($link, 'vidxden.com') !== false) ||(strpos($link, 'vidbux.com') !== false) ||(strpos($link, 'wootly.com') !== false)) {
      $link1=vix($link);
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif (strpos($link, 'loombo.com') !== false) {
      $l1=substr(strrchr($link,"/"),1);
      //http://loombo.com/embed-nztor3f4stri-640x318.html
      $link = "http://loombo.com/embed-".$l1."-640x318.html";
      $baza = file_get_contents($link);
      $link1 = str_between($baza,"addParam('flashvars','file=","'");
      $server = str_between($link,"http://","/");
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif (strpos($link, 'mainfile.net') !== false) {
      //http://mainfile.net/40pvl60th70s/cowry-mami.flv.htm
      $baza = file_get_contents($link);
      $oid=str_between($baza,'name="id" value="','"');
      $orand=str_between($baza,'name="rand" value="','"');
      //op=download2&id=40pvl60th70s&rand=1xctoajg&method_free=&method_premium=&down_direct=1
      $post="op=download2&id=".$oid."&rand=".$orand."&method_free=&method_premium=&down_direct=1";
      if (function_exists('curl_init')) {
         $ch = curl_init($link);
         sleep(10);
         curl_setopt ($ch, CURLOPT_POST, 1);
         curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
         curl_setopt($ch, CURLOPT_REFERER, $link);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
         $h = curl_exec($ch);
         curl_close ($ch);
      }
      $link1=str_between($h,'flashvars="file=','"');
      $server = str_between($link,"http://","/");
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif (strpos($link, 'rapidfiles.ws') !== false) {
      //http://www.rapidfiles.ws/evsza53dh7sv/X-Men_20United_20CD2.flv.htm
      $baza = file_get_contents($link);
      $oid=str_between($baza,'name="id" value="','"');
      $orand=str_between($baza,'name="rand" value="','"');
      //op=download2&id=7v6kvio637yv&rand=6gus1ry5&method_free=&method_premium=&down_direct=1
      $post="op=download2&id=".$oid."&rand=".$orand."&method_free=&method_premium=&down_direct=1";
      if (function_exists('curl_init')) {
         $ch = curl_init($link);
         curl_setopt ($ch, CURLOPT_POST, 1);
         curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
         $h = curl_exec($ch);
         curl_close ($ch);
      } else {
        //wget solution
        exec("rm -f /tmp/vix");
        $c="/sbin/wget -q --post-data '".$post."' ".$link." -O /tmp/vix";
        exec($c);
        $h=file_get_contents("/tmp/vix");
      }
      $link1=str_between($h,'flashvars="file=','"');
      $server = str_between($link,"http://","/");
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } else {
		$link1="";
	}
	if (($link1 <> "") && strcmp($link1,$lastlink) && (strpos($link1,"http") !== false) && (!preg_match("/<|>/",$title))) {
		$link2 = $baseurl.$link1;
 		$titledownload = substr(strrchr($link1,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link1.'</download>
    	<link>'.$link2.'</link>
    	<enclosure type="video/flv" url="'.$link2.'"/>
    	</item>
        ';
		$lastlink = $link1;
    }   //lastlink
}
/** END onlinemoca **/
/**################ flash... mediafile,file.....############**/
$videos = explode('flash', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1 = explode('ile=', $video);
  $t2 = explode('&', $t1[1]);
  $t3 = explode("'",$t2[0]);
  $link = urldecode($t3[0]);
  if (strpos($link,"wp-content") !==false) {  //serialepe.net !!!!!!!!
    $t2=explode("&",$t1[2]);
    $t3=explode("'",$t2[0]);
    $link = urldecode($t3[0]);
  }
  $link = str_prep($link);
  $server = str_between($link,"http://","/");
  $title = $server." - ".substr(strrchr($link,"/"),1);
  if (($link <> "") && strcmp($link,$lastlink) && (!preg_match("/<|>/",$title))) {
     //peteava
     //_standard.mp4
     if (strpos($link, '_standard.') !== false) {
        $title = $link;
        $token = peteava($link);
        if ($token <> "") {
          $link =  "http://content.peteava.ro/video/".$link."?start=0&token=".$token."1fe71d22";
        } else {
		  $link = "http://content.peteava.ro/video/".$link;
        }
     }
     if (strpos($link, 'http://') !== false){
		$link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if (($pg <> "") && (strpos($link,"serialepe.net") === false)) {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<download>'.$link.'</download>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
    	$lastlink = $link;
    	$link2 = str_replace("s2.serialepe.net","s3.serialepe.net",$link);
    	if ($link2 <> $link) {
          $titledownload1 = str_replace("s2.serialepe","s3.serialepe",$titledownload);
          $link1 = $baseurl.$link2;
          $server = str_between($link2,"http://","/");
          $title = $server." - ".substr(strrchr($link2,"/"),1);
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<download>'.$link2.'</download>
    	<name>'.$titledownload1.'.'.$ext.'</name>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
    	}
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
        <name>'.$titledownload.'.srt</name>
    	</item>
    	';
    	$srt2 = str_replace("s2.serialepe.net","s3.serialepe.net",$srt);
    	if ($srt2 <> $srt) {
    	echo '
    	<item>
    	<title>Subtitrare (s3)</title>
    	<download>'.$srt2.'</download>
        <name>'.$titledownload1.'.srt</name>
    	</item>
    	';
    	}
    	}
    }
  }
} //foreach
////filmerx !!!!
$videos = explode('lash', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1 = explode('flv=', $video);
  $t2 = explode('&', $t1[1]);
  $link = urldecode($t2[0]);
  $link = str_prep($link);
  $server = str_between($link,"http://","/");
  $title = $server." - ".substr(strrchr($link,"/"),1);
  if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
     $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
     echo '
     <item>
     <title>'.$title.'</title>
	 <link>'.$link1.'</link>
	 <name>'.$titledownload.'.'.$ext.'</name>
	 <download>'.$link.'</download>
     <enclosure type="video/flv" url="'.$link1.'"/>
     </item>
     ';
 	$lastlink = $link;
  }
} //foreach
//filmeonlinesubtitrate
$videos = explode('lash', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $t1 = explode('vdo=', $video);
  $t2 = explode('"', $t1[1]);
  $link = urldecode($t2[0]);
  $link=str_prep($link);
  $server = str_between($link,"http://","/");
  $title = $server." - ".substr(strrchr($link,"/"),1);
  if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
     $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
     echo '
     <item>
     <title>'.$title.'</title>
	 <link>'.$link1.'</link>
	 <name>'.$titledownload.'.'.$ext.'</name>
	 <download>'.$link.'</download>
     <enclosure type="video/flv" url="'.$link1.'"/>
     </item>
     ';
 	$lastlink = $link;
  }
} //foreach
/**############ <iframe , embed.....(novamov,videoweed,stagevu,divxstage.net,flvz.com)#######**/
//http://embed.novamov.com/embed.php?width=600&#038;height=480&#038;v=r10s5xdykpd6f
//http://embed.videoweed.com/embed.php?v=72drqpukot88p&amp;width=500&amp;height=400
if (strpos($html,"IFRAME") !== false) {
   $html = str_replace("IFRAME","iframe",$html);
}
$videos = explode("<iframe", $html);
unset($videos[0]);
foreach($videos as $video) {
   $srt = "";
   $video = str_replace("'",'"',$video);
   $video = str_replace("SRC","src",$video);
   $t1 = explode('src="', $video);
   $t2 = explode('"', $t1[1]);
   $link = urldecode($t2[0]);
   $link = str_prep($link);
   if ((strpos($link, 'novamov') !== false) || (strpos($link, 'videoweed') !== false)) {
      $baza = file_get_contents($link);
      $baza = str_replace("'",'"',$baza);
      $v1 = explode('file="', $baza);
      $v2 = explode('"', $v1[1]);
      $link = trim($v2[0]);
      $link = str_replace('"','',$link);
      $server = str_between($link,"http://","/");
      $title = $server." - ".substr(strrchr($link,"/"),1);
   } elseif (strpos($link, 'loombo.com') !== false) {
     $baza = file_get_contents($link);
     $link = str_between($baza,"addParam('flashvars','file=","'");
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
   } elseif (strpos($link, 'movshare') !== false){
     $baza = file_get_contents($link);
     $link = str_between($baza,'addVariable("file","','"');
     if ($link == "") {
        $link = str_between($baza,'param name="src" value="','"');
     }
      if ($link == "") {
         $link=str_between($baza,'flashvars.file="','"');
      }
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
   } elseif (strpos($link, 'vkontakte.ru') !== false){
     $baza = file_get_contents($link);
     $host = str_between($baza,"host=","&amp;");
     $uid = str_between($baza,"uid=","&amp;");
     $vtag = str_between($baza,"vtag=","&amp;");
     $hd = str_between($baza,"hd=","&amp;");
     $link = $host."u".$uid."/video/".$vtag.".360.mp4";
     if ($hd == "0") {
        $link = $link = $host."u".$uid."/video/".$vtag.".240.mp4";
     }
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
   } elseif (strpos($link, 'vk.com') !== false){
     $baza = file_get_contents($link);
     $host = str_between($baza,"var video_host = '","'");
     $uid = str_between($baza,"var video_uid = '","'");
     $vtag = str_between($baza,"var video_vtag = '","'");
     $hd = str_between($baza,"var video_max_hd = '","'");
     $link = $host."u".$uid."/video/".$vtag.".360.mp4";
     if ($hd == "0") {
        $link = $link = $host."u".$uid."/video/".$vtag.".240.mp4";
     }
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
   } elseif (strpos($link, 'stagevu') !== false){
     $baza = file_get_contents($link);
     $link = str_between($baza,'param name="src" value="','"');
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
   } elseif (strpos($link, 'divxstage.net') !== false){
     $baza = file_get_contents($link);
     $link = str_between($baza,'"file","','"');
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
   } elseif (strpos($link, 'flvz.com') !== false){
     $baza = file_get_contents($link);
     $link = str_between($baza,'"url": "','"');
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
   } elseif (strpos($link,'stickonline.ro') !==false){
     $baza = file_get_contents($link);
     $link = str_between($baza,"file=","&");
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
   } elseif ((strpos($link, 'divxden.com') !== false) ||(strpos($link, 'vidxden.com') !== false) ||(strpos($link, 'vidbux.com') !== false) ||(strpos($link, 'wootly.com') !== false)) {
     $link = vix($link);
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
   } elseif (strpos($link,'kiwi.kz') !==false){
     $file = get_headers($link);
     foreach ($file as $key => $value) {
       if (strstr($value,"Location")) {
         $link = urldecode(ltrim($value,"Location:"));
         $link = str_between($link,"file=","&");
       } // end if
     } // end foreach
   } elseif (strpos($link,"rofilm.info") !==false) {
     //http://rofilm.info/Media/kazzoskaku.php?link=2116&km=Grey/Greys S07E01.srt
     $baza = file_get_contents($link);
     $t1=explode('value="file=',$baza);
     $t2=explode("&",$t1[1]);
     $link = $t2[0];
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
     $t1=explode('captions.file=',$baza);
     $t2=explode("&",$t1[1]);
     $srt=$t2[0];
     $srt = str_replace(" ","%20",$srt);
   } elseif (strpos($link,"serialetvonline.info") !==false) {
     //http://www.serialetvonline.info/Media/rrr.php?kl=NTMromania/NextTopModelRomaniaS01E01
     $baza = file_get_contents($link);
     $link = str_between($baza,'"flashvars" value="file=','&');
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
     $t1=explode('captions.file=',$baza);
     $t2=explode("&",$t1[1]);
     $srt=$t2[0];
     $srt = str_replace(" ","%20",$srt);
   } elseif (strpos($link,"zshare.net") !==false) {
     //http://www.zshare.net/videoplayer/player.php?SID=dl033&FID=75535391&FN=private.practice.s03e21.hdtv.xvid-2hd.flv&iframewidth=648&iframeheight=415&width=640&height=370&H=75535391bd51dec1
     //http://dl033.zshare.net/stream/815e798f1601021b3bef2faea7bf802a/75535391/1298517662/private.practice.s03e21.hdtv.xvid-2hd.flv//5194292060/?start=0
     //NOT SURE ABOUT THIS !!!!
     $a=explode("H=",$link);
     $b=explode("&",$a[1]);
     $v=$b[0];
     $url="http://www.zshare.net/video/".$v."/";
     $h = file_get_contents($url);
     $link=str_between($h,'<iframe src="','"');
     $baza = file_get_contents($link);
     $link=str_between($baza,'file: "','"');
     $server = str_between($link,"http://","/");
     $f=explode("//",$link);
     $f=$f[1];
     $title = $server." - ".substr(strrchr($f,"/"),1);
   } elseif (strpos($link,"nukeshare.com") !==false) {
     $link = nukeshare($link);
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
   } else {
     $link = "";
   }
   $link = str_prep($link);
   if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
      $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
  	  echo '
      <item>
  	  <title>'.$title.'</title>
  	  <link>'.$link1.'</link>
    	<download>'.$link.'</download>
    	<name>'.$titledownload.'.'.$ext.'</name>
  	  <enclosure type="video/flv" url="'.$link1.'"/>
  	  </item>
        ';
  	$lastlink = $link;
   }
  	if (($srt <> "") && (strpos($srt,".srt") !==false)) {
    	echo '
    	<item>
    	<title>Subtitrare</title>
    	<download>'.$srt.'</download>
        <name>'.$titledownload.'.srt</name>
    	</item>
    	';
  	}
} //foreach
//www.4shared.com/embed/264489980/d9d252d8
if (strpos($html, '4shared.com/embed') !== false) {
   $videos = explode("<embed", $html);
   unset($videos[0]);
   $videos = array_values($videos);
   foreach($videos as $video) {
    $link = str_between($video,'src="','"');
    if (strpos($video, '4shared.com/embed') !== false) {
       $file = get_headers($link);
       foreach ($file as $key => $value) {
         if (strstr($value,"Location")) {
            $url = ltrim($value,"Location: ");
            $link = str_between($url,"file=","&");
         } // end if
   	} // end foreach
    $server = str_between($link,"http://","/");
    $title = $server." - ".substr(strrchr($link,"/"),1);
    if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
      $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
  	 $lastlink = $link;
     }
    }
    }
}
if (strpos($html, '4shared.com') !== false) {
	$videos = explode("SWFObject", $html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
	$link = str_between($video,"'file','","'");
	$server = str_between($link,"http://","/");
	$title = $server." - ".substr(strrchr($link,"/"),1);
    if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
      $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
  	 $lastlink = $link;
     }
    }
}
//megavideo
if (strpos($html, 'megavideo') !== false) {
$videos = explode('<object', $html);
unset($videos[0]);
$videos = array_values($videos);
$n = 1;
foreach($videos as $video) {
    $link = str_between($video,'value="http','"');
    $link="http".$link;
	if (strpos($link,"megavideo") !== false) {
		if (strpos($link,"mv_player.swf") === false) {
			$file = get_headers($link);
		 	foreach ($file as $key => $value) {
		    if (strstr($value,"location")) {
		      $url = ltrim($value,"location: ");
		      $link = substr(strrchr($url, '='),1);
		     } // end if
		   } // end foreach
		   $id = $link;
        }else {
  	      $v = explode("v=",$link);
  	      $id = $v[1];
        }
		$title = "megavideo link";
		$link1 = "http://127.0.0.1:82/scripts/php1/mega.php?id=".$id;
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	</item>
        ';
     }
}
}
//video.google
if (strpos($html, 'googleplayer.swf') !== false) {
	$videos = explode("docid=", $html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
      $docid = explode("&",$video);
	  $link = "http://video.google.com/videoplay?docid=".$docid[0];
	  $server = str_between($link,"http://","/");
	  $title = $server." - ".substr(strrchr($link,"/"),1);
	  if (($link <> "") && strcmp($link,$lastlink)) {
        $link1 = "http://127.0.0.1:83/cgi-bin/translate?stream,,".$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
    	$lastlink = $link;
     }
   }
}
//filebox
if (strpos($html, 'filebox.ro/get_video') !== false) {
	$videos = explode("source_script=", $html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
	$s = str_between($video,"videoserver",".");
	$f = str_between($video,"key=","&");
	$link = "http://static.filebox.ro/filme/".$s."/".$f.".flv";
	$server = str_between($link,"http://","/");
	$title = $server." - ".substr(strrchr($link,"/"),1);
	 if (($link <> "") && strcmp($link,$lastlink)) {
		$link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
    	$lastlink = $link;
    }
  }
}
//peteava
if (strpos($html, 'peteava.ro/embed') !== false) {
	$videos = explode("peteava.ro/embed/", $html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
		$t = explode('"',$video);
		$link = "http://www.peteava.ro/embed/".$t[0];
		$h = file_get_contents($link);
		$id = str_between($h,"stream.php&file=","&");
        $token = peteava($id);
        if ($token <> "") {
          $link =  "http://content.peteava.ro/video/".$id."?start=0&token=".$token."1fe71d22";
        } else {
		  $link = "http://content.peteava.ro/video/".$id;
        }
		$server = str_between($link,"http://","/");
		$title = $server." - ".$id;
		if (($id <> "") && strcmp($link,$lastlink)) {
          $link1 = $baseurl.$link;
		$titledownload = $id;
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
    	  $lastlink = $link;
       }
  }
}
//embed.trilulilu.ro
//http://embed.trilulilu.ro/video/bollllo/9fb39f6144d6be/0xe9eff4.swf
if (strpos($html, 'embed.trilulilu.ro') !== false) {
	$videos = explode("embed.trilulilu.ro/", $html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
		$t = explode('/',$video);
		$name = $t[1];
		$hash = $t[2];
		if (strpos($hash,".swf") !==false) {
           $t1=explode(".",$hash);
           $hash=$t1[0];
           }
		$link = "http://www.trilulilu.ro/".$name."/".$hash;
		$h = file_get_contents($link);
		$userid = str_between($h, 'userid=', '&');
		$hash = str_between($h, 'hash=', '&');
		$server = str_between($h, 'server=', '&');
		$link1="http://fs".$server.".trilulilu.ro/stream.php?type=video&amp;source=site&amp;hash=".$hash."&amp;username=".$userid."&amp;key=ministhebest";
		$link = $link1."&amp;format=mp4-720p";
		$AgetHeaders = @get_headers($link);
        if (!preg_match("|200|", $AgetHeaders[0])) {
           $link = $link1."&amp;format=mp4-360p";
           $AgetHeaders = @get_headers($link);
           if (!preg_match("|200|", $AgetHeaders[0])) {
              $link = $link1."&amp;format=flv-vp6";
              $AgetHeaders = @get_headers($link);
              if (!preg_match("|200|", $AgetHeaders[0])) {
                 $link="";
              }
           }
        }
		$server = str_between($link,"http://","/");
		$title = $server." - ".$hash ;
		if (($userid <> "") && strcmp($link,$lastlink)) {
			$link1 = $baseurl.$link;
		$titledownload = $hash;
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
    	    $lastlink = $link;
         }
   }
}
//youtube http://www.youtube.com/v/nEJ9V6nsVQ4&
//http://www.youtube.com/watch?v=5f-MYl-HzNw
if (strpos($html, 'www.youtube.com/v/') !== false) {
	$videos = explode("www.youtube.com/v/", $html);
	unset($videos[0]);
	$videos = array_values($videos);
	foreach($videos as $video) {
	//$id = explode("&",$video);
	$v_id = substr($video, 0, 11);
	//$v_id = $id[0];
    if(!preg_match('/[^0-9A-Za-z._.-]/',$v_id)) {
	  $link = "http://www.youtube.com/v/".$v_id;
	  $server = str_between($link,"http://","/");
	  $title = $server." - ".substr(strrchr($link,"/"),1);
	  if (($link <> "") && strcmp($link,$lastlink)) {
       $link1 = "http://127.0.0.1:83/cgi-bin/translate?stream,HD:1,http://www.youtube.com/watch?v=".$v_id;
       echo '
          <item>
    	  <title>'.$title.'</title>
    	  <link>'.$link1.'</link>
    	  <enclosure type="video/flv" url="'.$link1.'"/>
    	  </item>
          ';
       $lastlink = $link;
       }
     }
  }
}
//************** Other old links ********************************
$videos = explode('<object', $html);
$videos = array_values($videos);
unset($videos[0]);
foreach($videos as $video) {
	$link = urldecode(str_between($video,"MediaLink=","&"));
	$server = str_between($link,"http://","/");
	$title = $server." - ".substr(strrchr($link,"/"),1);
    if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
      $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
  	 $lastlink = $link;
     }
     $t1=explode('value="',$video);
     $t2=explode('"',$t1[1]);
     $link = $t2[0];
     if (strpos($link,'kiwi.kz') !==false){
     $file = get_headers($link);
     foreach ($file as $key => $value) {
       if (strstr($value,"Location")) {
         $link = urldecode(ltrim($value,"Location:"));
         $link = str_between($link,"file=","&");
       } // end if
     } // end foreach
	$server = str_between($link,"http://","/");
	$title = $server." - ".substr(strrchr($link,"/"),1);
    if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
      $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
  	 $lastlink = $link;
     }
     }
}
//flashvars="playlistfile=
if (strpos($html, 'flashvars="playlistfile=') !== false) {
	$t1=explode('flashvars="playlistfile=',$html);
	$link = str_between($t1[1],"file=","&");
	$server = str_between($link,"http://","/");
	$title = $server." - ".substr(strrchr($link,"/"),1);
    if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
      $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
  	 $lastlink = $link;
     }
}
//encodeURIComponent (efilmeonline.ro)
if (strpos($html, 'encodeURIComponent') !== false) {
   $videos = explode("SWFObject", $html);
   unset($videos[0]);
   $videos = array_values($videos);
   foreach($videos as $video) {
     $link = str_between($video,"encodeURIComponent('","'");
     $server = str_between($link,"http://","/");
     $title = $server." - ".substr(strrchr($link,"/"),1);
     if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
        $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
     $lastlink = $link;
     }
   }
}
//jurnaltv.ro
if (strpos($html, 'jurnaltv.ro') !== false) {
   $link = str_between($html,'vPlayer.swf?f=','"');
   $h = file_get_contents($link);
   $link = str_between($h,"<src>","</src>");
   $server = str_between($link,"http://","/");
   $title = $server." - ".substr(strrchr($link,"/"),1);
   if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
      $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
  	 $lastlink = $link;
    }
}
 //stagevu.ro
if (strpos($html, 'stagevu.ro') !== false) {
   $link = str_between($html,"'video/divx' src='","'");
   $server = str_between($link,"http://","/");
   $title = $server." - ".substr(strrchr($link,"/"),1);
   if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
      $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
  	 $lastlink = $link;
    }
}
//stagevu.com
if (strpos($html, 'stagevu.com') !== false) {
   $link = str_between($html,"] = '","'");
   $server = str_between($link,"http://","/");
   $title = $server." - ".substr(strrchr($link,"/"),1);
   if (($link <> "") && strcmp($link,$lastlink) && (strpos($link,"http") !== false) && (!preg_match("/<|>/",$title))) {
      $link1 = $baseurl.$link;
		$titledownload = substr(strrchr($link,"/"),1);
		$pct = substr($titledownload, -4, 1);
		if ($pct == ".") {
           $ext = substr($titledownload, -3);
           $titledownload = substr($titledownload, 0, -4);
        } else {
          $ext = "flv";
        }
		if ($pg <> "") {
           $titledownload = $pg;
        }
    	echo '
        <item>
    	<title>'.$title.'</title>
    	<link>'.$link1.'</link>
    	<name>'.$titledownload.'.'.$ext.'</name>
    	<download>'.$link.'</download>
    	<enclosure type="video/flv" url="'.$link1.'"/>
    	</item>
    	';
  	 $lastlink = $link;
    }
}
   echo '
   <item>
   <title>Download Manager</title>
   <link>http://127.0.0.1:82/scripts/util/level.php</link>
   </item>
   ';
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
?>
</channel>
</rss>
