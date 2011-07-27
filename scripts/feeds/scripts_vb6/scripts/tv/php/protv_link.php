#!/usr/local/bin/Resource/www/cgi-bin/php
<?php
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
function mylink($string){
$html = file_get_contents($string);
$l = str_between($html,'value=&quot;','&');
if ($l <> "") {
$file = get_headers($l);
 foreach ($file as $key => $value)
   {
    if (strstr($value,"Location"))
     {
      $url = ltrim($value,"Location: ");
      $link1 = str_between($url,"file=","&");
     } // end if
   } // end foreach
   if ($link1 <> "") {
   return $link1;
}
}
}
$query = $_GET["file"];
if($query) {
   $queryArr = explode(',', $query);
   $link = $queryArr[0];
   $image = $queryArr[1];
}
if (strpos($image,"web3.protv.ro") !== false) {
       $video=mylink($link);
print $video;
} elseif (strpos($image,"assets.sport.ro") !== false) {
  	$link1 = str_replace("thumb2_","",$image);
  	$link1 = str_replace("thumb1_","",$image);
  	$link1 = str_replace(".jpg",".flv",$link1);
  	$link1 = str_replace("-","_",$link1);
  	$AgetHeaders = @get_headers($link1);
    if (preg_match("|200|", $AgetHeaders[0])) {
print $link1;
     } else {
         $video=mylink($link);
print $video;
      }
}
?>
