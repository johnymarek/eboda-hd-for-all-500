<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

    <channel>
    <title>YouTube RSS</title>
    <menu>main menu</menu>


    <?php
    $rss = $_GET["rss"];

$html = file_get_contents("$rss");

?>

<?php
function str_between($string, $start, $end){ 
  $string = " ".$string; $ini = strpos($string,$start); 
  if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
  return substr($string,$ini,$len); 
}
$videos = explode('<entry', $html);
unset($videos[0]);

$videos = array_values($videos);

foreach($videos as $video) {
#    echo "beg"; echo $video; echo "end";
  $t1 = explode("<media:player url='http://www.youtube.com", $video);
#    echo "beg1"; echo $t1[1]; echo "end1";
  $t2 = explode('&amp;feature=youtube_gdata_player', $t1[1]);
#    echo "beg2"; echo $t2[0]; echo "end2";
  $link = 'http://www.youtube.com'.$t2[0]."&hd=1";
  $pos = strrpos($link, "watch"); 
  if ($pos !== false) { 
    $t1 = explode("<title type='text'>", $video); 
    $t2 = explode('</title>', $t1[1]); 
    $title = htmlspecialchars_decode($t2[0]);

    /* $t1 = explode('src="', $video); */
    /* $t2 = explode('"', $t1[1]); */
    /* $image = $t2[0]; */
    /* $pos = strrpos($image, ".jpg"); */
    /* if ($pos === false) { */
      $t1 = explode("<media:thumbnail url='", $video);
      $t2 = explode("'", $t1[1]);
      $image = $t2[0];
    /* } */
    $link = "http://127.0.0.1:82/scripts/php/yt_link.php?file=".$link;    
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';	
    echo '</item>';
    print "\n";
  }
}

?>

</channel>
</rss>
