#!/usr/local/bin/Resource/www/cgi-bin/php
<?php
error_reporting(0);
$filelink = $_GET["file"];
$filelink=urldecode($filelink);
if (strpos($filelink,"adf.ly") !==false) {
  $h1=file_get_contents($filelink);
  $filelink=str_between($h1,"var url = '","'");
}
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
//peteava
function r() {
$i=mt_rand(4096,0xffff);
$j=mt_rand(4096,0xffff);
return  dechex($i).dechex($j);
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
  $r=r();
  $s = hexdec($seed);
  $local3 = crunch($s,$movie);
  $local3 = crunch($local3,"0");
  $local3 = crunch($local3,$r);
  return strtolower(dechex($local3)).$r;
}
/** end peteava **/
function cv($s) {
  $g=ord("g");
  $c=ord($s);
  if ($c < 58) {
    $c=$s;
  } else {
    $c=$c-$g + 16;
  }
return $c;
}
function get_unpack($k,$char_rep,$pos_link,$h) {
  $g=ord("g");
  $f=explode("return p}",$h);
  $e=explode("'.split",$f[$k]);
  $t=$e[0];
  $a=explode(";",$t);
  //print_r($a); //for debug only
  $w=explode("|",$a[$char_rep]); //char list for replace
  $t1=explode("'",$a[$pos_link]); // where is final link
  $fl= $t1[3];
  $s1=explode("/",$fl);
  $r="";
  for ($i=0;$i<strlen($fl)-1;$i++) {
      if (preg_match("/[A-Za-z0-9_]/",$fl[$i])) {
         $m=$w[cv($fl[$i])];
         if ($m=="") $m=$fl[$i];
         $r=$r.$m;
      } else {
        $r=$r.$fl[$i];
      }
  }
  return $r;
}
function rapidmov($string) {
  $h = file_get_contents($string);
  $g=ord("g");
  $f=explode("return p}",$h);
  $e=explode("'.split",$f[1]);
  $t=$e[0];
  $a=explode(";",$t);
  $w=explode("|",$a[9]);
  $t1=explode("'",$a[4]);
  $fl= $t1[3];
  $s1=explode("/",$fl);
  $r="";
  for ($i=0;$i<strlen($fl)-1;$i++) {
      if (preg_match("/[A-Za-z0-9_]/",$fl[$i])) {
         $r=$r.$w[cv($fl[$i])];
      } else {
        $r=$r.$fl[$i];
      }
  }
return $r;
}
function videobb($l) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $l);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
  curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
  $page = curl_exec($ch);
  curl_close($ch);
  preg_match_all('/\{"d":(false|true),"l":"([^"]+)","u":"([^"]+)"\}/i', $page, $st);
  $stream = array();
  for ($i = 0; $i < count($st[0]); $i++) {
    $stream[$st[2][$i]] = array(($st[1][$i] == "true" ? true : false), base64_decode($st[3][$i]));
  }
  if (count($stream) > 1) {
    foreach ($stream as $st => $da) {
      if ($da[0] == true) {
        $fl=$da[1];
      } else {
        $fl=$da[1]; // ?????
      }
    }
  } else {
    $qs = array_rand($stream);
    $fl = $stream[$qs][1];
  }
  return $fl;
}
function vk($string) {
  if (strpos($string,"video_ext.php") === false) {
	$h = file_get_contents($string);
	$t1=explode("nvar vars",$h);
	$l=$t1[1];
	$uid=str_between($l,'\"uid\":\"','\"');
	$host=str_between($l,'"host\":\"','\"');
	$host=str_replace("\\/","/",$host);
	$host=str_replace("\\/","/",$host);
	$host=str_replace("\/","/",$host);
	$vtag=str_between($l,'"vtag\":\"','\"');
	$r=$host."u".$uid."/video/".$vtag.".360.mp4";
 } else {
    $baza = file_get_contents($string);
    $host = str_between($baza,"var video_host = '","'");
    $uid = str_between($baza,"var video_uid = '","'");
    $vtag = str_between($baza,"var video_vtag = '","'");
    $hd = str_between($baza,"var video_max_hd = '","'");
    $r = $host."u".$uid."/video/".$vtag.".360.mp4";
    if ($hd == "0") {
      $r = $host."u".$uid."/video/".$vtag.".240.mp4";
    }
 }
  return $r;
}
function youtube($file) {
if(preg_match('/youtube\.com\/(v\/|watch\?v=|embed\/)([\w\-]+)/', $file, $match)) {;
  $id = $match[2];
  $l="http://www.youtube.com/get_video_info?video_id=".$id;
  $h=file_get_contents($l);
  $h = urldecode($h);
  $h=explode('fmt_stream_map=',$h);
  $h=$h[1];
  $videos = explode(',', $h);
  for ($i=0;$i<count($videos);$i++) {
    $t1=explode("|", $videos[$i]);
    $tip=$t1[0];
    $r=$t1[1];
    if ($tip=="22") break;
    if ($tip=="18") break;
  }
}
return $r;
}
function flvz($string) {
if (strpos($string,"embed") === false) {
  $string=str_replace("video","embed",$string);
}
$h = file_get_contents($string);
$r = str_between($h,'"url": "','"');
return $r;
}
function putlocker($string) {
     $id=substr(strrchr($string,"/"),1);
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $string);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
     curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
     $h = curl_exec($ch);
     curl_close($ch);
     $t1=explode('form method="post"',$h);
     $t2=explode('value="',$t1[1]);
     $t3=explode('"',$t2[1]);
     $hash=$t3[0];
     $post="hash=".$hash."&confirm=Close+Ad+and+Watch+as+Free+User";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $string);
     curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
     curl_setopt ($ch, CURLOPT_POST, 1);
     curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
     $h = curl_exec($ch);
     curl_close($ch);
     $url="http://www.putlocker.com/get_file.php?embed_stream=".$id;
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     $h = curl_exec($ch);
     curl_close($ch);
     $t1=explode('media:content url="',$h);
     $t2=explode('"',$t1[2]);
     $r = $t2[0];
     return $r;
}
function megavideo($string) {
  if (preg_match('/(v=)([A-Za-z0-9_]+)/', $string, $m)) {
    $id=$m[2];
  } elseif (preg_match('/(v\/)([A-Za-z0-9_]+)/', $string, $m)) {
    $file = get_headers($string);
 	foreach ($file as $key => $value) {
      if (strstr($value,"location")) {
        $url = ltrim($value,"location: ");
        $id = substr(strrchr($url, '='),1);
      } // end if
    } // end foreach
  } elseif (preg_match('/(d=)([A-Za-z0-9_]+)/', $string, $m)) {
    $h=file_get_contents($string);
    $id=str_between($h,'flashvars.v = "','"');
  }
  return $id;
}
//***************Here we start**************************************
$filelink=str_prep($filelink);
if ((strpos($filelink,"vidxden") !==false) || (strpos($filelink,"divxden") !==false)) {
  if (strpos($filelink,"embed") === false) {
    $t=explode("/",$filelink);
    $id= $t[3];
    $filelink=$t[0]."/".$t[1]."/".$t[2]."/"."embed-".$id."-width-653-height-362.html";
  }
  $h = file_get_contents($filelink);
  $link=get_unpack(1,11,5,$h);
} elseif (strpos($filelink,"vidbux") !==false) {
  if (strpos($filelink,"embed") === false) {
    $t=explode("/",$filelink);
    $id= $t[3];
    $filelink=$t[0]."/".$t[1]."/".$t[2]."/"."embed-".$id."-width-653-height-362.html";
  }
  $h = file_get_contents($filelink);
  $link=get_unpack(1,8,4,$h);
} elseif (strpos($filelink,'movreel') !==false) {
  preg_match('/movreel\.com\/(embed\/)?+([\w\-]+)/', $filelink, $m);
  $id=$m[2];
  $filelink = "http://movreel.com/embed/".$id;
  $h = file_get_contents($filelink);
  $link=str_between($h,'<param name="src" value="','"');
} elseif (strpos($filelink,'videoweed') !==false) {
  if (strpos($filelink,"embed") !== false) {
    preg_match('/(v=)([A-Za-z0-9_]+)/', $filelink, $m);
    $id=$m[2];
    $s=explode("/",$filelink);
    $filelink="http://".$s[2]."/embed.php?v=".$id."&amp;width=900&amp;height=600";
  }
  $h = file_get_contents($filelink);
  $link = str_between($h,'file="','"');
} elseif (strpos($filelink,'novamov') !==false) {
  if (strpos($filelink,"embed") !== false) {
    preg_match('/(v=)([A-Za-z0-9_]+)/', $filelink, $m);
    $id=$m[2];
    $s=explode("/",$filelink);
    $filelink="http://".$s[2]."/embed.php?v=".$id."&amp;width=600&amp;height=480";
  }
  $h = file_get_contents($filelink);
  $link = str_between($h,'file="','"');
} elseif (strpos($filelink, 'videobb.com') !== false) {
  $id=substr(strrchr($filelink,"/"),1);
  $l="http://www.sheepser.com/vb23.php?s1=".$id;
  $h=file_get_contents($l);
  $t1=explode('url="',$h);
  $t2=explode('"',$t1[1]);
  $link=$t2[0];
  if (strpos($link,"videobb") === false) {
    $filelink="http://www.videobb.com/player_control/settings.php?v=".$id;
    $link=videobb($filelink);
  }
} elseif (strpos($filelink, 'videozer.com') !== false) {
  $id=substr(strrchr($filelink,"/"),1);
  $l="http://www.sheepser.com/vz23.php?s1=".$id;
  $h=file_get_contents($l);
  $t1=explode('url="',$h);
  $t2=explode('"',$t1[1]);
  $link=$t2[0];
  if (strpos($link,"videozer") === false) {
    $filelink="http://www.videozer.com/player_control/settings.php?v=".$id;
    $link=videobb($filelink);
  }
} elseif ((strpos($filelink, 'vk.com') !== false) || (strpos($filelink, 'vkontakte.ru') !== false)) {
  $link=vk($filelink);
} elseif (strpos($filelink, 'movshare') !== false){
  preg_match('/(v=)([A-Za-z0-9_]+)/', $filelink, $m);
  $id=$m[2];
  $filelink = "http://embed.movshare.net/embed.php?v=".$id;
  $baza = file_get_contents($filelink);
  $link = str_between($baza,'file="','"');
} elseif (strpos($filelink, 'youtube') !== false){
  $link=youtube($filelink);
} elseif (strpos($filelink, 'flvz.com') !== false){
  $link=flvz($filelink);
} elseif (strpos($filelink, 'rapidmov.net') !== false){
  $link=rapidmov($filelink);
} elseif (strpos($filelink, 'putlocker.com') !== false){
  $link=putlocker($filelink);
} elseif (strpos($filelink, 'peteava.ro/embed') !== false) {
  preg_match('/(video\/)([A-Za-z0-9_]+)/', $filelink, $m);
  $id=$m[2];
  $filelink = "http://www.peteava.ro/embed/video/".$id;
  $h = file_get_contents($filelink);
  $id = str_between($h,"hd_file=","&");
  if ($id == "") {
    $id = str_between($h,"stream.php&file=","&");
  }
  if ($id <> $last_peteava) {
    $last_peteava=$id;
    $token = peteava($id);
    $link =  "http://content.peteava.ro/video/".$id."?start=0&token=".$token;
  }
} elseif (strpos($filelink, 'peteava.ro/id') !== false) {
  $h = file_get_contents($filelink);
  $id = str_between($h,"hd_file=","&");
  if ($id == "") {
    $id = str_between($h,"stream.php&file=","&");
  }
  if ($id <> $last_peteava) {
    $last_peteava=$id;
    $token = peteava($id);
    $link =  "http://content.peteava.ro/video/".$id."?start=0&token=".$token;
  }
} elseif (strpos($filelink, 'content.peteava.ro') !== false) {
  $id = str_between($filelink,"stream.php&file=","&");
  if ($id <> $last_peteava) {
    $last_peteava=$id;
    $token = peteava($id);
    $link =  "http://content.peteava.ro/video/".$id."?start=0&token=".$token;
  }
} elseif (strpos($filelink,'vimeo.com') !==false){
  //http://player.vimeo.com/video/16275866
  if (strpos($filelink,"player.vimeo.com") !==false) {
     $id=substr(strrchr($filelink,"/"),1);
     $link="http://127.0.0.1/cgi-bin/translate?stream,,http://vimeo.com/".$id;
  } else {
     $link="http://127.0.0.1/cgi-bin/translate?stream,,".$filelink;
  }
} elseif (strpos($filelink, 'googleplayer.swf') !== false) {
  $t1 = explode("docid=", $filelink);
  $t2 = explode("&",$t1[1]);
  $link = "http://127.0.0.1/cgi-bin/translate?stream,,http://video.google.com/videoplay?docid=".$t2[0];
} elseif (strpos($filelink, 'filebox.ro/get_video') !== false) {
   $s = str_between($filelink,"videoserver",".");
   $f = str_between($filelink,"key=","&");
   $link = "http://static.filebox.ro/filme/".$s."/".$f.".flv";
} elseif (strpos($filelink, 'megavideo.com') !== false) {
   $link="http://127.0.0.1/cgi-bin/scripts/php1/mv.cgi?v=".megavideo($filelink);
}
print $link;
?>
