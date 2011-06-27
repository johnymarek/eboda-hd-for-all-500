#!/usr/local/bin/Resource/www/cgi-bin/php
<?php
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
$link = $_GET["file"];
$out="";
$srt = str_replace(".xml",".srt",$link);
$html = file_get_contents($link);
$videos = explode('<p', $html);
unset($videos[0]);
$videos = array_values($videos);
$n=1;
foreach($videos as $video) {
$t1=explode('begin="',$video);
$t2=explode('"',$t1[1]);
$start=$t2[0];
if (strlen($start)==5) {
$start="00:".$start.",000";
} else {
$start=$start.",000";
}
$t1=explode('end="',$video);
$t2=explode('"',$t1[1]);
$end=$t2[0];
if (strlen($end)==5) {
$end="00:".$end.",000";
} else {
$end=$end.",000";
}
$line=str_between($t1[1],">","</p");
$line=str_replace("<br/>","\r\n",$line);
$out = $out.$n."\r\n";
$out = $out.$start." --> ".$end."\r\n";
$out = $out.$line."\r\n";
$out = $out."\r\n";
$n++;
}
$out = preg_replace("/<(.*)>|(\{(.*)\})/e","",$out);
$rm = "rm -f ".$srt;
exec ($rm);
$fp = fopen($srt, 'w');
fwrite($fp, $out);
fclose($fp);

$rm = "rm -f ".$link;
exec ($rm);
?>
