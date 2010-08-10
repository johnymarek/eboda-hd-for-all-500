<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">


<channel>
	<title>dstanley-couchpotatoes</title>
	<menu>main menu</menu>


<?php

$html = file_get_contents("http://dstanley-couchpotatoes.blogspot.com/");

$videos = explode("<a dir='ltr'", $html);
unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {
    $t1 = explode("href='", $video);
    $t2 = explode("'", $t1[1]);
    $link =$t2[0];
    //$link = str_replace(' ','%20',$link);
    $t1 = explode("'>", $video);
    $t2 = explode("<", $t1[1]);
    $title = $t2[0];
		if (strlen($title) > 1 && ($title <> "0#") && (stripos($title,"z.")=== false) && (stripos($title,"Today's Shows")=== false) && (stripos($title,"Primetime Schedule")=== false) && (stripos($title,"What's been canceled")=== false)) {
		$link="http://ims.hdplayers.net/scripts/php/dstanley.php?query=".urlencode($title).",".$link;

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '</item>';
    print "\n";
  }
}
?>

</channel>
</rss>