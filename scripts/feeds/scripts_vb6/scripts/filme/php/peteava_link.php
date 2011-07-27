<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
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

  $out=`/scripts/bin/t 0x$seed $movie`;
  $out=rtrim($out);
  return $out;
  
  $r=r();
  $s = hexdec($seed);
  $local3 = crunch($s,$movie);
  $local3 = crunch($local3,"0");
  $local3 = crunch($local3,$r);
  return strtolower(dechex($local3)).$r;
}
$baseurl = "http://127.0.0.1:83/cgi-bin/translate?stream,Content-type:video/x-flv,";
$link = $_GET["file"];
$t1=explode(",",$link);
$link = $t1[0];
$pg = urldecode($t1[1]);
if ($pg == "") {
   $pg = "peteava.ro - link";
}
$html = file_get_contents($link);
  $id = str_between($html,"hd_file=","&");
  if ($id == "") {
    $id = str_between($html,"stream.php&file=","&");
  }
$token = peteava($id);
if ($token <> "") {
  $link =  "http://content.peteava.ro/video/".$id."?start=0&token=".$token;
} else {
  $link = "http://content.peteava.ro/video/".$id;
}
$server = str_between($link,"http://","/");
$title = $server." - ".$id; 
//$link = $baseurl.$link;
print $link;
?>
