<?php echo "<?phpxml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>ucoz - links</title>
	<menu>main menu</menu>


<?php
$n = 1;
$link = $_GET["file"];
//echo strrchr($link,"/");
$link = str_replace(' ','%20',$link);
$link = str_replace('[','%5B',$link);
$link = str_replace(']','%5D',$link);
$image = "/scripts/image/movies.png";

$html = file_get_contents($link);
$videos = explode('flashvars="', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode('file=', $video);
    $t2 = explode('&', $t1[1]);
    $link = $t2[0];

//    $t1 = explode(' title="', $video);
//    $t2 = explode('"', $t1[1]);
    $title = 'Link '.$n;
    if ($link <> "") {
$pos = strpos($link, '.flv');
if ($pos === false) {  
	$t1 = explode('file=', $video);
    $t2 = explode('&', $t1[2]);
    $link = $t2[0];	
  }  
//  echo strrchr($link,"/");
$link = str_replace(' ','%20',$link);
$link = str_replace('[','%5B',$link);
$link = str_replace(']','%5D',$link);
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="'.$image.'" />';
    echo '<enclosure type="video/flv" url="'.$link.'"/>';	
    echo '</item>';
    $n=$n+1;
  }
}  


?>


</channel>
</rss>