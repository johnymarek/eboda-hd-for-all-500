<?php
$id = $_GET['id'];
//$id="Z-JXfyvlPh0";
$IPaddress=$_SERVER['REMOTE_ADDR'];
$pos = strpos($IPaddress, ".");
$ip = "ip=".substr($IPaddress, 0, $pos);
$page = file_get_contents('http://www.youtube.com/get_video_info?&video_id='.$id);
$page = file_get_contents('http://www.youtube.com/get_video_info?&video_id='.$id);
$page = file_get_contents('http://www.youtube.com/get_video_info?&video_id='.$id);
$p = urldecode($page);
$arr = explode("|",$p);
if ( strstr( $arr[0], "fmt_stream_map=22"))
{
 foreach ( $arr as $element )
 {
  if ( strstr( $element, "itag=22" ) )
  {
   $goodurl=$element;
   //$goodurl = urlencode($url);
   $goodurl = str_replace(" ","%20",$goodurl);
   break;
  }
 }
}
elseif ( strstr( $arr[0], "status"))
{
 foreach ( $arr as $element )
 {
  if ( strstr( $element, "fmt_stream_map=34" ))
  {
   $goodurl=$element;
   //$goodurl = urlencode($url);
   $goodurl = str_replace(" ","%20",$goodurl);
   break;
  }
 }
}
elseif ( strstr( $arr[0], "fmt_stream_map" ))
{
foreach ( $arr as $element ) {
if ( strstr( $element, "token" ) ) {
$goodurl=$element;
$goodurl = str_replace(" ","%20",$goodurl);
$goodurl = "";
break;
}
}
}
//echo "HTTP/1.1 302 Found\r\n";
//echo "location: ".$goodurl."\r\n";
//echo "Content-Length: 0\r\n";
//echo "Connection: close\r\n";
//echo "\r\n";
$goodurl = str_replace("ip=69",$ip,$goodurl);
header("Location: $goodurl");
?>
