<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>publika.md</title>
	<menu>main menu</menu>

<?php
//$html = file_get_contents("http://www.1tvbacau.ro/video/Stiri--c1.html");
$html = file_get_contents("http://www.publika.md/");
function str_between($string, $start, $end){ 
	$string = " ".$string; $ini = strpos($string,$start); 
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini; 
	return substr($string,$ini,$len); 
}
function ascii2entities($string){
    for($i=128;$i<=255;$i++){
        $entity = htmlentities(chr($i), ENT_QUOTES, 'cp1252');
        $temp = substr($entity, 0, 1);
        $temp .= substr($entity, -1, 1);
        if ($temp != '&;'){
            $string = str_replace(chr($i), '', $string);
        }
        else{
            $string = str_replace(chr($i), $entity, $string);
        }
    }
    return $string;
}
$image = "/tmp/hdd/volumes/HDD1/scripts/image/publika.jpg";
$videos = explode('<li>', $html);

unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
    
    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];   
		if ($link <> "") {
		$link = 'http://127.0.0.1:82/scripts/php/publika_link.php?file='.$link;

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