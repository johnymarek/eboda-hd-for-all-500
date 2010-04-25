<?php
function url_exists($url)
{
if(file_get_contents($url, FALSE, NULL, 0, 0) === false) return false;
return true;
}


$id = $_GET['id'];
$page = file_get_contents('http://www.youtube.com/get_video_info?&video_id='.$id);
$p = urldecode($page);
$arr = explode("|",$p);
if (strstr($page,"fmt_url_map=22"))
{
end($arr);
$last_element = current($arr);
preg_match('/&token=(.*?)=&/', $last_element, $newtoken);

$file = get_headers("http://youtube.com/get_video?video_id=".$id."&t=".$newtoken[1]."=&eurl=&el=detailpage&ps=default&gl=US&hl=en&fmt=22");

if (strstr($file[20],"videoplayback"))
 {
  $url = ltrim($file[20],"Location: ");
 } // end if

else
 {
  foreach ($file as $key => $value)
   {
    if (strstr($value,"videoplayback"))
     {
      $url = ltrim($value,"Location: ");
     } // end if
   } // end foreach
 } // end else
              


} // end if strstr. file is not hd ?

else
{

if (empty($newtoken)) {
    preg_match('/&token=(.*?)%3D/', $page, $newtoken);
    $token = urldecode("$newtoken[1]%3D");
}    
$check = stripos($newtoken[1], 'ad_loggin');
if ($check >0)
    {
    preg_match('/token=(.*?)&thumbnail_url=/', $newtoken[1], $goodtoken);
    $token = urldecode($goodtoken[1]);
    }
	
    $file = get_headers("http://youtube.com/get_video?video_id=".$id."&t=".$token."&fmt=18");
    
 if (strstr($file[20],"videoplayback"))
 {
 $url = ltrim($file[20],"Location: ");
 }
 else
 {
 foreach ($file as $key => $value)
 {
 if (strstr($value,"videoplayback"))
 {
 $url = ltrim($value,"Location: ");
 }
 }
 }
 }
header("Location: $url");
?>