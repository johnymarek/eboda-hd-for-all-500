#!/usr/local/bin/Resource/www/cgi-bin/php
<?php
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
$l = $_GET["file"];
$l=urldecode($l);
$l=str_prep($l);
$html = file_get_contents($l);
if(preg_match_all("/(http\b.*?)(\"|\')+/i",$html,$matches)) {
$links=$matches[1];
}
$s="/youtube\.c|videa\.hu\/flvplayer|kiwi\.kz/i";
for ($i=0;$i<count($links);$i++) {
  $cur_link=$links[$i];
  if (preg_match($s,$cur_link)) {
   if (strpos($cur_link, 'youtube') !== false){
     $link=youtube($cur_link);
   } elseif (strpos($cur_link,'kiwi.kz') !==false){
     $file = get_headers($cur_link);
     foreach ($file as $key => $value) {
       if (strstr($value,"Location")) {
         $link = urldecode(ltrim($value,"Location:"));
         $link = str_between($link,"file=","&");
       } // end if
     } // end foreach
  } elseif (strpos($cur_link,'videa.hu') !==false){
      preg_match('/(v=)([A-Za-z0-9_]+)/', $cur_link, $m);
      $id=$m[2];
      $cur_link="http://videa.hu/videok/sport/".$id;
      $html = file_get_contents($cur_link);
      $id=str_between($html,"flvplayer.swf?f=",".0&");
      $link="http://videa.hu/static/video/".$id;
  }
}
}
print $link;
?>
