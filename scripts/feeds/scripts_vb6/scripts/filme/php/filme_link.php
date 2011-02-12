<?php
error_reporting(0);
$filelink=$_ENV["QUERY_STRING"];
$t1=explode(",",$filelink);
$filelink = $t1[0];
$filelink = str_replace("*",",",$filelink);
$pg = urldecode($t1[1]);
if ($pg == "") {
   $pg_title = "Link";
} else {
  $pg_title = $pg;
  $pg = preg_replace('/[^A-Za-z0-9_]/','_',$pg);
}
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
$html = file_get_contents($filelink);
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
	     $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif (strpos($link,'stickonline') !== false) {
      $baza = file_get_contents($link);
      $link1 = str_between($baza,"file=","&");
      $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif ((strpos($link, 'divxden.com') !== false) ||(strpos($link, 'vidxden.com') !== false) ||(strpos($link, 'vidbux.com') !== false)) {
      $link1 = divxden($link);
      $server = str_between($link1,"http://","/");
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
//"Alege Una Din Variante","</table>");
//"http://www.urlscurt.com/Short-Url/Short-Url4.php?link=http://www.novamov.com/video/2x11ff3e96jt5"
if (strpos($filelink, 'onlinemoca') !== false) {
$videos = explode('link', $html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $v1 = explode('=', $video);
	$v2 = explode('"', $v1[1]);
	$link = $v2[0];
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
	     $title = $server." - ".substr(strrchr($link1,"/"),1);
    } elseif (strpos($link,'stickonline') !== false) {
      $baza = file_get_contents($link);
      $link1 = str_between($baza,"file=","&");
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
}  //foreach
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
     if (strpos($link, '_standard.mp4') !== false) {
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
    	$srt1 = str_between($video,'captions.file=','&');
    	$t1=explode('"',$srt1);
    	$srt = $t1[0];
    	if (strpos($srt,"http") === false) {
          //www.veziserialeonline.info
          if (strpos($filelink,"veziserialeonline") !==false) {
             $srt = "http://www.veziserialeonline.info".$srt;
          }
        }
        $pct = substr($srt, -4, 1);
    	if (($srt <> "") && ($pct == ".")) {
    	echo '
    	<item>
    	<title>Subtitrare</title>
    	<download>'.$srt.'</download>
        <name>'.$titledownload.'.srt</name>
    	</item>
    	';
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
   } elseif ((strpos($link, 'divxden.com') !== false) ||(strpos($link, 'vidxden.com') !== false) ||(strpos($link, 'vidbux.com') !== false)) {
     $link = divxden($link);
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
    $link = str_between($video,'value="','"');
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
