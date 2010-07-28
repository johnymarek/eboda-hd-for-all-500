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
$url = ($arr[1]);
header("Location: $url");
?>