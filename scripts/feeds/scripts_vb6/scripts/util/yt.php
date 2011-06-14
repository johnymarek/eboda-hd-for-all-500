#!/usr/local/bin/Resource/www/cgi-bin/php
<?php
$file=$_GET["file"];
if(preg_match('/youtube\.com\/(v\/|watch\?v=)([\w\-]+)/', $file, $match)) {;
  $id = $match[2];
  $link="http://www.youtube.com/get_video_info?video_id=".$id;
  $html=file_get_contents($link);
  $html = urldecode($html);
  $h=explode('fmt_stream_map=',$html);
  $html=$h[1];
  $videos = explode(',', $html);
  for ($i=0;$i<count($videos);$i++) {
    $t1=explode("|", $videos[$i]);
    $tip=$t1[0];
    $link=$t1[1];
    if ($tip=="22") break;
    if ($tip=="18") break;
  }
}
print $link;
?>
